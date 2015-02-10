<?php
include_once "page/admin/controller/admin.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class SablonEdit_Admin_Controller extends Page_Edit {
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->_model = $this->__loadPublicModel("sablon","_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    
    public function __show(){
        parent::__show();   
        $this->_view->assign("MODUL_NAME", Rimo::$_config->SB_MODUL_EDIT_NAME);
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/sablon/view/admin.sablon_edit.tpl"));
    }
}
?>