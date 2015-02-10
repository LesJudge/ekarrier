<?php
class HirShowHir_Site_Controller extends RimoController {
    public $_name = "HirShowReszletes";
    
    public function __construct() {
        $this->__loadModel("_ShowHir");
        $this->__run();
    }
    
    public function __show(){
        try{
            $data = $this->_model->getTartalom($_REQUEST["link"]);
            Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>"Hírek", "link"=>"hirek/"),2=>array("nev"=>$data[0]["hir_cim"])));     
            UserLoginOut_Controller::verifyJogcsoportAccess($data[0]["jogcsoport_id"]);
            if($_COOKIE["hir_megtekintes"]!=$data[0]["hir_id"]){
                $this->_model->updateMegtekintes($data[0]["hir_id"]);
            }
            setcookie("hir_megtekintes", $data[0]["hir_id"], time()+300);
            
            $this->_view->assign("data",$data);
            $this->_view->assign("kapcsolodo", $this->_model->getKapcsolodo($data[0]["hir_id"]));
            Rimo::$_site_frame->assign("PageName", $data[0]["hir_cim"]);
			Rimo::$_site_frame->assign("site_title",$data[0]["hir_cim"]);
            Rimo::$_site_frame->assign("site_description",$data[0]["hir_leiras"]);
            Rimo::$_site_frame->assign("site_keywords",$data[0]["hir_meta_kulcsszo"]);
            Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/hir/view/site.hir_reszletes.tpl"));
        }catch(Exception_MYSQL $e){
            throw new Exception_404();
        }
    }
}
?>