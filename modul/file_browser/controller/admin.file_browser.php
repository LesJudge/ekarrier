<?php
class File_browser_Admin_Controller extends RimoController {    
    private $directory_tree;
    private $view_dir;
    private $file_type;
    private $current_dir;
    
    public $_name = "FileBrowser";
    public $_verify_event_manual = true;

    public function __construct() {
        $this->_action_type = $_REQUEST;
        
        $this->__loadModel("_Create");
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify(array($this->_model->dir_name), 'BtnCreateDir', $this->_name));
        $this->__addEvent("BtnCreateDir", "CreateFolder");
        $this->__addEvent("BtnDeleteDir", "DeleteFolder");
        $this->__addEvent("BtnUploadFile", "UploadFile");
        $this->__addEvent("BtnDeleteFile", "DeleteFile");
        
        $this->file_type = trim(stripcslashes($_GET["type"]));
        $_GET["viewdir"] = trim(stripcslashes($_GET["viewdir"]));
        if ($_GET["viewdir"] AND is_dir($_GET["viewdir"]) AND strpos($_GET["viewdir"], Rimo::$_config->FILE_PATH)===0) {
            $this->view_dir = $_GET["viewdir"];
            $this->current_dir =  trim(stripcslashes($_GET["act_dir"]));
        } else {
            $this->view_dir = Rimo::$_config->FILE_PATH;
            $this->current_dir = Rimo::$_config->FILE_PATH;
        }
        $this->__run();
    }

    public function __show(){
        $this->_view->assign("REQUEST_URI", $_SERVER["REQUEST_URI"]);
        $this->_view->assign("file_type", $this->file_type);
        $this->_view->assign("file_max_size",  $this->_model->file->_verify["maxsize"]);
        $this->_view->assign("file_max_normalized_size",  Create::byte_converter($this->_model->file->_verify["maxsize"]));
        $this->_view->assign("current_file_dir", $this->view_dir);
        if($this->current_dir==Rimo::$_config->FILE_PATH)
            $this->_view->assign("current_dir", "upload");
        else
            $this->_view->assign("current_dir", $this->current_dir);
        $this->_view->assign("file_tree", $this->print_files($this->view_dir));       
        $this->print_tree(Rimo::$_config->FILE_PATH);
        $this->_view->assign("directory_tree", $this->directory_tree);

        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/file_browser/view/admin.file_browser.tpl"));
    }

    public function onClick_DeleteFolder() {
        if($this->view_dir == Rimo::$_config->FILE_PATH){
            throw new Exception_Form_Error(LANG_FB_error_fo);
        }
        if (Create::directory_delete($this->view_dir) === true) {
            $this->view_dir = Rimo::$_config->FILE_PATH;
            $this->current_dir = Rimo::$_config->FILE_PATH;
            throw new Exception_Form_Message(LANG_FB_msg_del_dir);
        }
        throw new Exception_Form_Error(LANG_FB_error_del_dir);
    }

    public function onClick_CreateFolder() {
        $this->_params["TxtDirName"]->_value = Create::remove_accents($this->_params["TxtDirName"]->_value);
        $this->verifyInputItem(array($this->_params["TxtDirName"]));
        
        $dir_full_name = $this->view_dir . '/' . $this->_params["TxtDirName"]->_value;
        $name = $this->_params["TxtDirName"]->_value;
        unset($this->_params["TxtDirName"]->_value);
        if (is_dir($dir_full_name)) {
            throw new Exception_Form_Error(LANG_FB_error_create_dir."<strong>{$name}</strong> ".LANG_FB_error_create_dir_add);
        }
        if (mkdir($dir_full_name) === true) {
            chmod($dir_full_name, 0777);
            throw new Exception_Form_Message(LANG_FB_msg_create_dir);
        }
        throw new Exception_Form_Error(LANG_FB_error_create_dir);
    }

    public function onClick_UploadFile() {
        $this->verifyInputItem(array($this->_params["File"]));
        $target_dir = str_replace(Rimo::$_config->FILE_PATH,"upload/",$this->view_dir . "/");
        $file =Create::upload_file($this->getItemValue("File"), false, $target_dir);
        
        throw new Exception_Form_Message(LANG_FB_msg_file.": {$file}");
    }

    public function onClick_DeleteFile() {
        if(is_file($this->view_dir . "/" . $this->_events["BtnDeleteFile"]->_value)===false){
            throw new Exception_Form_Error(LANG_FB_error_no_file);
        }
        if (unlink($this->view_dir . "/" . $this->_events["BtnDeleteFile"]->_value) === true) {
            throw new Exception_Form_Message(LANG_FB_msg_del_file);
        }
        throw new Exception_Form_Error(LANG_FB_error_del_file);
    }

    public function print_tree($dir = ".", $level = 1) {
        if (is_dir($dir)) {
            $d = opendir($dir);
            while ($f = readdir($d)) {
                if (strpos($f, ".") === 0) continue;
                $ff = $dir . "/" . $f;
                if (is_dir($ff)) {
                    $class = '';
                    if ($ff == $this->view_dir) $class = "open";
                    $this->directory_tree[] = array("dir" => $ff, "name" => $f, "level" => $level, "class" => $class);
                    $this->print_tree($ff, $level + 1);
                }
            }
        }
        return true;
    }

    public function print_files($dir = ".") {
        $d = opendir($dir);
        $i = 0;
        while ($f = readdir($d)) {
            $type=false;
            if (strpos($f, ".") === 0) continue;
            $ff = $dir . "/" . $f;
            $ext = pathinfo($ff, PATHINFO_EXTENSION);
            if (!is_dir($ff)) {
                $imageinfo = @getimagesize($ff);
                if ($imageinfo && $imageinfo[2] > 0 && $imageinfo[2] < 4) {
                    if ($imageinfo[2] == 1) {
                        $imagetype = "gif";
                    } elseif ($imageinfo[2] == 2) {
                        $imagetype = "jpg";
                    } elseif ($imageinfo[2] == 3) {
                        $imagetype = "jpg";
                    } else {
                        $imagetype = "image";
                    }
                    $row[$i]["type"] = $imagetype;
                    $row[$i]["image"] = true;
                    $type = true; 
                }
                else{
                    $row[$i]["type"] = $ext;
                    $type = true;
                } 
                if($type===true){
                    $row[$i]["file"] = $ff;
                    $row[$i]["dir"] = str_replace(Rimo::$_config->FILE_PATH,'',str_replace($f,'',$ff));
                    $row[$i]["name"] = $f;
                    $row[$i]["size"] = Create::byte_converter(filesize($ff));
                    $i++;
                }
            }
        }
        return $row;
    }    
}
?>