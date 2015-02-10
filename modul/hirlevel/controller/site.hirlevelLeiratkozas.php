<?php
class HirlevelLeiratkozas_Site_Controller extends RimoController {
    public $_name = "HirlevelLeiratkozas";
    private $tartalom_show_model = "";
    
    public function __construct() {
        $this->__loadModel("_Leliratkozas");
        $this->tartalom_show_model = $this->__loadPublicModel("tartalom","_Show");
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        try{
            $this->_model->hirlevelLeiratkozas($_REQUEST["user_id"]);
            $data = $this->tartalom_show_model->getTartalomFromID(3);
            Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>$data[0]["tartalom_cim"])));
            Rimo::$_site_frame->assign("PageName", $data[0]["tartalom_cim"]);
            $this->_view->assign("data",$data);
            Rimo::$_site_frame->assign("site_title",$data[0]["tartalom_cim"]);
            Rimo::$_site_frame->assign("site_description",$data[0]["tartalom_leiras"]);
            Rimo::$_site_frame->assign("site_keywords",$data[0]["tartalom_meta_kulcsszo"]);
            
            Rimo::$_site_frame->assign("Content", $this->_view->fetch("modul/tartalom/view/site.tartalom_show.tpl"));
        }
        catch(Exception_MYSQL $e){
            throw new Exception_404();
        }
    }
}
?>