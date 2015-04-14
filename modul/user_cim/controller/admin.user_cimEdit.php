<?php
include_once "page/admin/controller/admin.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class User_cimEdit_Admin_Controller extends Page_Edit {
    public $_name = "UserCimEdit";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_Edit");
        parent::__construct();
        $user_id = mysql_real_escape_string($_REQUEST["user_id"]);
       	$this->_model->_user_id = $user_id; 
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    
    public function __runEvents(){    	
    	if(!is_numeric($this->_model->_user_id))
        	throw new Exception_Form_Error("Hiba! Nincs felhasználó azonosító. Kérjülk kattintson a mégse gombra");
    	parent::__runEvents();			        	
    }
    
    public function __show(){
        parent::__show();
		$this->_view->assign("user_id",$this->_model->_user_id);   
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/user_cim/view/admin.user_cim_edit.tpl"));
    }
}
?>