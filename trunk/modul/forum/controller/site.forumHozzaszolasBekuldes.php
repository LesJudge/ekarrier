<?php
include_once "page/all/controller/page.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class ForumHozzaszolasBekuldes_Site_Controller extends Page_Edit
{
    
    public $_name = "HozzaszolasBekuldes";
    
    public function __construct()
    {
        //UserLoginOut_Site_Controller::isAuthorized('Exception_404');
        Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->_model = $this->__loadPublicModel("hozzaszolas","_SiteBekuldes");
        $this->_model->_tableName = "forum_hozzaszolas";
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, "BtnSave", $this->_name));
        $this->__run();
    }
    
    public function __runEvents()
    {
    	$this->_params["SessCaptcha"]->_value = $_SESSION["captcha"];
   	parent::__runEvents();
    }
  
    public function __show()
    {
        //UserLoginOut_Site_Controller::isAuthorized('Exception_404');
        parent::__show();
        $this->_params["TxtCaptcha"]->_value='';
        $data = $this->_model->getTartalom($_REQUEST["kapcs_id"],"forum");
        if($_REQUEST["parent_id"])
            $this->_view->assign("parent_data", $this->_model->getParentTartalom($_REQUEST["parent_id"]));
        else
            $this->_view->assign("parent_data", $data);
    	$this->_view->assign("kapcs_id",$_REQUEST["kapcs_id"]);
        Rimo::$_site_frame->assign("Indikator", array(
            1=>array("nev"=>"Fórum témák", "link"=>"forum/"),
            2=>array("nev"=>$data[0]["targy_min"], "link"=>"forum/{$_REQUEST["kapcs_id"]}/"),
            3=>array("nev"=>"Hozzászólás"),
            )
        );
        Rimo::$_site_frame->assign("PageName",$data[0]["targy_min"]);
        Rimo::$_site_frame->assign("site_title",$data[0]["targy_min"]);
        Rimo::$_site_frame->assign("site_description",$data[0]["tartalom_min"]);
        Rimo::$_site_frame->assign("site_keywords",$data[0]["targy_min"]);
        Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/forum/view/site.forum_hozzaszolas_bekuldes.tpl"));
    }

    
    public function onClick_New(){
        try{
        	$this->_model->_params["Nyelv"]->_value = Rimo::$_config->SITE_NYELV_ID;
        	parent::onClick_New();
       	}catch(Exception_Form_Message $e){
       		$this->formReset(true);
            $this->onLoad_New();
       		throw new Exception_Form_Message("Sikeres fórum hozzászólás beküldés. Adminisztrátori jóváhagyást követően fog megjelenni oldalunkon az Ön hozzászólása. Köszönjük.");
       	}
    }
    
    public function formReset($torles=false) {
        if($torles)
            parent::formReset();
    }
}
?>