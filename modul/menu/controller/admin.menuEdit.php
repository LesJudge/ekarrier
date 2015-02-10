<?php
include_once "page/admin/controller/admin.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class MenuEdit_Admin_Controller extends Admin_Edit {
    protected $_verify_event_manual=true;
    
    public function __construct() {
        $this->_name = "MenuList";
        $this->__loadModel("_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __runParams(){
        parent::__runParams();
        $this->_model->removeAccentsFromLink();
    }
    
    public function __show(){
        parent::__show();   
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/menu/view/admin.menu_edit.tpl"));
    }
    
    public function onLoad_Edit(){
        parent::onLoad_Edit();
        $this->_view->assign("no_view_parent",true); 
    }
    
    public function onClick_Modify(){
        $this->_model->generateLinkAndName($this->_params["SelDinamikusElem"]);
        $this->verifyInputItem($this->_params);
        parent::onClick_Modify();
    }
    
    public function onClick_New(){
        if(!$this->_model->modifyID)
            $this->_model->generateLinkAndName($this->_params["SelDinamikusElem"]);
        $this->verifyInputItem($this->_params);
        parent::onClick_New();
    }
}
?>