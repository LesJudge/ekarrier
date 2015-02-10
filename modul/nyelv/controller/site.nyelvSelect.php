<?php
class NyelvSelect_Site_Controller extends RimoController{
     public function __construct(){
        $this->__run();
    }
    
    public function __run(){
        $this->__loadModel("_Site_Select");
        $this->_model->getNyelvek();
        $this->_model->modifyDefaultLang();
        parent::__run();
        $this->__show();
    }
    
    public static function setLangAndReloadPage($nyelv_id){
    	if(array_key_exists($nyelv_id, nyelv_Site_Select_Model::$nyelvek)){
			$_SESSION["NYELV_ID"] = $nyelv_id;
			header("Refresh: 0; url=".$_SERVER["REDIRECT_URL"]);
		}
	}
	    
	public function __show(){
        $this->_view->assign("nyelvek", $this->_model->getNyelvek());
        Rimo::$_site_frame->assign("Nyelv_Valaszto", $this->_view->fetch("modul/nyelv/view/site.nyelv_select.tpl"));
    }
}
?>