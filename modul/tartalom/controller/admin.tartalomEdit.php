<?php
include_once "page/admin/controller/admin.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class TartalomEdit_Admin_Controller extends Admin_Edit {
    public $_name = "TartalomEdit";
    public function __construct() {
        $this->__loadModel("_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__addEvent("BtnDeleteMegtekintes", "DeleteMegtekintes");
        $this->__addEvent("BtnDeleteFile", "DeleteFile");
        $this->__run();
    }
    
    public function __runParams(){
        parent::__runParams();
        $this->_model->removeAccentsFromLink();
        $this->_model->removeDelimitterFromKulcsszo();
    }
    
    public function __show(){
        parent::__show();
        $this->_view->assign("kep_max_size", Create::byte_converter($this->_params["File"]->_verify["maxsize"]));   
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/tartalom/view/admin.tartalom_edit.tpl"));
    }
    
    public function onClick_DeleteMegtekintes(){
        $this->_model->deleteMegtekintes();
        throw new Exception_Form_Message("Sikeresen törölte a megtekintések számát.");
    }
    
    public function onClick_DeleteFile(){
        $this->_model->deleteKep($this->_events["BtnDeleteFile"]->_value);
        throw new Exception_Form_Message("Sikeresen törölte a képet.");
    }
}
?>