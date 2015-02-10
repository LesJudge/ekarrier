<?php
include_once "page/all/controller/page.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class HirlevelUsercsoportrendezes_Admin_Controller extends Page_Edit {
    public $_name = "HirlevelUsercsoportRendezesEdit";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_Usercsoportrendezes_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__addEvent("BtnReload","Reload");
        $this->__run();
    }
    
    public function __show(){
        parent::__show();   
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hirlevel/view/admin.hirlevelusercsoportrendezes.tpl"));
    }   
    
    protected function onLoad_New(){
       throw new Exception_Form_Error("Nincs kiválasztott csoport");
    }
    
    protected function onClick_Reload(){
    }
}
?>