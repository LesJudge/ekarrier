<?php
include_once "page/all/controller/page.list.php";
class KeresoShowList_Site_Controller extends Page_List {
    public $_name = "KeresoShowList";
    
    public function __construct() {
        $this->__loadModel("_ShowList");
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        $this->_view->assign("keresoszo",mysql_real_escape_string($_REQUEST["szo"]));
        
        Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>"Keresés")));
        Rimo::$_site_frame->assign("PageName", "Keresés");
        Rimo::$_site_frame->assign("site_title","Keresés");
        Rimo::$_site_frame->assign("site_description","Keresés");
        Rimo::$_site_frame->assign("site_keywords","Keresés");
        Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/kereso/view/site.kereso_list.tpl"));
    }
}
?>