<?php

class HirShowList_Site_Controller extends Page_List {
    public $_name = "HirShowList";
    
    public function __construct() {
        $this->__loadModel("_ShowList");
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        try{
            $data = $this->_model->getTartalom($_REQUEST["link"]);
            $indikator = $this->_model->__getParent($data[0]["hir_kategoria_id"]);
            Rimo::$_site_frame->assign("Indikator", $indikator);
            Rimo::$_site_frame->assign("PageName", $data[0]["kategoria_cim"]);
            UserLoginOut_Controller::verifyJogcsoportAccess($data[0]["jogcsoport_id"]);
            if(!isset($_COOKIE['hir_kategoria_megtekintes']) || $_COOKIE["hir_kategoria_megtekintes"]!=$data[0]["hir_kategoria_id"]){
                $this->_model->updateMegtekintes($data[0]["hir_kategoria_id"]);
            }
            setcookie("hir_kategoria_megtekintes", $data[0]["hir_kategoria_id"], time()+300);
            
            $this->_view->assign("data",$data);
            //$this->_view->assign("kapcsolodo", $this->_model->getKapcsolodo($data[0]["hir_kategoria_id"]));
            //$this->_view->assign("searchTree", $this->getTree($data[0]["hir_kategoria_id"]));
            Rimo::$_site_frame->assign("site_title",$data[0]["kategoria_cim"]);
            Rimo::$_site_frame->assign("site_description",$data[0]["kategoria_leiras"]);
            Rimo::$_site_frame->assign("site_keywords",$data[0]["kategoria_meta_kulcsszo"]);
            Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/hir/view/site.hir_list.tpl"));
        }catch(Exception_MYSQL $e){
            throw new Exception_404();
        }
    }
    
    private function getTree($id){
        try{
            $tree = $this->_model->loadTree($id);
            $count = count($tree);
            $html = "<ul class='dropdown right'>";
            
            for ($i=0; $i<$count; $i++) { 
                $html .= "<li class='topnav-".$tree[$i]["szint"]."'>" . "<a href='{$tree[$i]["link"]}/' class='frames'>".$tree[$i]["menu_nev"]."</a>";
                if ($tree[$i]["szint"] < $tree[$i+1]["szint"]) {
                        $html .= "<ul class='subnav-".$tree[$i]["szint"]."'>";
    			} elseif ($tree[$i]["szint"] == $tree[$i+1]["szint"]) {
    				$html .= "</li>";
    			} else {
    				$diff = $tree[$i]["szint"] - $tree[$i+1]["szint"];
    				$html .= str_repeat("</li></ul>", $diff) . "</li>";
    			}
            }
            return $html;
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
}
?>