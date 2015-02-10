<?php
include_once "page/admin/controller/admin.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class NyelvSzotaredit_Admin_Controller extends Admin_Edit {
    public $_name = "NyelvSzotarEdit";
    public function __construct() {
        $this->__loadModel("_Szotar_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    
    public function __show(){
        parent::__show();   
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/nyelv/view/admin.nyelvszotar_edit.tpl"));
    }
    
    public function onLoad_New(){
        parent::onLoad_New();
        $this->__setParamValue("SelModul");
    }
}
?>