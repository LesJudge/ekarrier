<?php
include_once "page/all/controller/page.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class HirlevelUseredit_Admin_Controller extends Page_Edit {
    public $_name = "HirlevelUserEdit";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_User_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    
    public function __show(){
        parent::__show();   
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hirlevel/view/admin.hirleveluser_edit.tpl"));
    }
}
?>