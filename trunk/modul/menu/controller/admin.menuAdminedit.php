<?php
include_once "page/admin/controller/admin.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class MenuAdminedit_Admin_Controller extends Admin_Edit {
    public function __construct() {
        $this->_name = "AdminMenuList";
        $this->__loadModel("_Admin_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    
    public function __show(){
        parent::__show();   
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/menu/view/admin.menuadmin_edit.tpl"));
    }
    
    public function onLoad_Edit(){
        parent::onLoad_Edit();
        $this->_view->assign("no_view_parent",true); 
    }
    
    public function onClick_Modify(){
        $this->_model->verifyModulFunction($this->getItemValue("TxtLink"));
        parent::onClick_Modify();
    }
    
    public function onClick_New(){
        $this->_model->verifyModulFunction($this->getItemValue("TxtLink"));
        parent::onClick_New();
    }
}
?>