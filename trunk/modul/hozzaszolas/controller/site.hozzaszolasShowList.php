<?php
include_once "page/all/controller/page.list.php";
class ForumShowList_Site_Controller extends Page_List {
    public $_name = "ForumShowList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_ShowList");
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        try{
            Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>"Fórum témák")));
            Rimo::$_site_frame->assign("PageName","Fórum témák");
            Rimo::$_site_frame->assign("site_title","Fórum témák");
            Rimo::$_site_frame->assign("site_description","Fórum témák");
            Rimo::$_site_frame->assign("site_keywords","Fórum témák");
            Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/forum/view/site.forum_list.tpl"));
        }catch(Exception_MYSQL $e){
            throw new Exception_404();
        }
    }
}
?>