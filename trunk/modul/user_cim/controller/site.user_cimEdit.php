<?php
include_once "page/admin/controller/admin.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class User_cimEdit_Site_Controller extends Page_Edit {
    public $_name = "UserCimSiteEdit";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_Edit");
        parent::__construct();
       	$this->_model->_user_id = UserLoginOut_Controller::$_id; 
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    
    public function __runEvents(){    	
    	if(!is_numeric($this->_model->_user_id))
        	throw new Exception_Form_Error("Hiba!");
    	parent::__runEvents();			        	
    }
    
    public function __show(){
        parent::__show();
		$this->_view->assign("user_id",$this->_model->_user_id);   
		Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>"Címek","link"=>"cimek/"),2=>array("nev"=>"Cím felvitel / szerkesztés")));
        Rimo::$_site_frame->assign("PageName", "Cím felvitel / szerkesztés");
        Rimo::$_site_frame->assign("site_title","Cím felvitel / szerkesztés");
        Rimo::$_site_frame->assign("site_description","Cím felvitel / szerkesztés");
        Rimo::$_site_frame->assign("site_keywords","Cím felvitel / szerkesztés");
        Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/user_cim/view/site.user_cim_edit.tpl"));
    }
    
	public function onClick_New(){
        try{
        	parent::onClick_New();
       	}catch(Exception_Form_Message $e){
       		throw new Exception_Form_Message("Sikeres új cím felvitele");
       	}
    }
    
    public function onClick_Modify(){
        try{
			parent::onClick_Modify();
        }catch(Exception_Form_Message $e){
       		throw new Exception_Form_Message("Sikeres módosítás");
       	}
    }
    
    protected function onLoad_Edit_DefaultData() {
         try {
            $this->_model->__formValues();          
         }
         catch (Exception_Mysql_Null_Rows $e) {
            $this->__addScript("setTimeout('window.location.href=\"".Rimo::$_config->DOMAIN."cimek/"."\"', 5000);");
            throw new Exception_Form_Error(LANG_PageEdit_error_modositas);
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error($e->getMessage());
        }
    }
    
    protected function onLoad_Edit(){
        try{
            $info = $this->_model->__editData();
            foreach($info as $key=>$val){
                $this->_view->assign($key, $val);    
            }
        }
        catch (Exception_Mysql_Null_Rows $e) {
        	$this->__addScript("setTimeout('window.location.href=\"".Rimo::$_config->DOMAIN."cimek/"."\"', 5000);");
        	$this->formReset(); 	
            throw new Exception_Load_error("Módosítás hiba");
    	} 
    }
}
?>