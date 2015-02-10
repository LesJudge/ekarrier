<?php
include_once "page/all/controller/page.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class ForumBekuldes_Site_Controller extends Page_Edit {
    public $_name = "ForumSiteBekuldes";
    
    public function __construct()
    {
        //UserLoginOut_Site_Controller::isAuthorized('Exception_404');
        Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->__loadModel("_SiteBekuldes");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, "BtnSave", $this->_name));
        $this->__run();
    }
    
    public function __runEvents(){
    	$this->_params["SessCaptcha"]->_value = $_SESSION["captcha"];
   		parent::__runEvents();
    }
  
    public function __show(){
        parent::__show();
        $this->_params["TxtCaptcha"]->_value='';
        Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>"Fórum témák","link"=>"forum/"),2=>array("nev"=>"Fórum téma beküldés")));
        Rimo::$_site_frame->assign("PageName", "Fórum téma beküldés");
        Rimo::$_site_frame->assign("site_title","Fórum téma beküldés");
        Rimo::$_site_frame->assign("site_description","Fórum téma beküldés");
        Rimo::$_site_frame->assign("site_keywords","Fórum téma beküldés");
        
		Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/forum/view/site.forum_bekuldes.tpl"));
    }

    public function onClick_New(){
        try{
        	$this->_model->_params["Nyelv"]->_value = Rimo::$_config->SITE_NYELV_ID;
        	parent::onClick_New();
       	}catch(Exception_Form_Message $e){
       		$this->formReset(true);
            $this->onLoad_New();
       		throw new Exception_Form_Message("Sikeres fórum téma beküldés. Adminisztrátori jóváhagyást követően fog megjelenni oldalunkon az Ön témája. Köszönjük.");
       	}
    }
    
    public function formReset($torles=false) {
        if($torles)
            parent::formReset();
    }
}
?>