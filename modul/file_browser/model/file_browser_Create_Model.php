<?php
class File_browser_Create_Model extends Model {
   public $dir_name;
   public $file;
   
   public function __construct(){
        $this->file = $this->addItem("File");
        $this->file->_action_type = &$_FILES;
        $this->file->_verify["file"] = true;
        $this->file->_verify["maxsize"] = 4194300;
        
        $this->dir_name = $this->addItem("TxtDirName");
        $this->dir_name->_verify["string"] = true;
        $this->dir_name->_verify["maxlength"] = 15;
    }
}
?>