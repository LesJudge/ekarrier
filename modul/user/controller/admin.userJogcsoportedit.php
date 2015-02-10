<?php
include_once "page/admin/controller/admin.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class UserJogcsoportedit_Admin_Controller extends Page_Edit {
    public $_name = "UserJogcsoportEdit";
    protected $_multiple_lang = false;
    protected $_verify_event_manual = true;
    
    public function __construct() {
        $this->__loadModel("_Jogcsoport_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__addEvent("BtnReload", "pageReload");
        $this->__run();
    }
    
    public function __runEvents(){
        if(UserLoginOut_Controller::$_id!=1 AND $this->_model->modifyID==1)
            throw new Exception_Form_Error("Önnek nincs joga ezt a jogosultság csoportot módosítani!");
        parent::__runEvents();
        $this->_model->selectJog();
    }
    
    public function __show(){
        parent::__show();   
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/user/view/admin.userjogcsoport_edit.tpl"));
    }
    
    public function onClick_pageReload(){
    }
    
    public function onClick_New(){
        $this->verifyInputItem($this->_model->_params);
        parent::onClick_New();
    }
    
    public function onClick_Modify() {
        $this->verifyInputItem($this->_model->_params);
        parent::onClick_Modify();
    }
}
?>