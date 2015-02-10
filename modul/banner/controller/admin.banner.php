<?php
include_once "page/admin/controller/admin.list.php";

class Banner_Admin_Controller extends Admin_List {
    public $_name = "BannerList";
    
    public function __construct() {
        $this->__loadModel("_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        $this->_view->assign("POZICIO_AZ_OLDALON", Rimo::$_config->POZICIO_AZ_OLDALON);
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/banner/view/admin.banner_list.tpl"));    
    }

    public function onClick_Filter() {
        $tol = $this->getItemValue("FilterDatumTol");
        $ig = $this->getItemValue("FilterDatumIg");
                
        $this->setWhereInput("banner_nev LIKE '%:item%' OR banner_link LIKE '%:item%'", "FilterSzuro");
		if($tol AND $ig){
            $this->setWhereInput("banner_megjelenes>=':item'", "FilterDatumTol");
            $this->setWhereInput("banner_lejarat<=':item'", "FilterDatumIg");
        }
		elseif($tol){
			$this->setWhereInput("banner_megjelenes>=':item'", "FilterDatumTol");
            unset($_SESSION[$this->_name]["FilterDatumIg"]);         
        }
		elseif($ig){
            $this->setWhereInput("banner_lejarat<=':item'", "FilterDatumIg");
            unset($_SESSION[$this->_name]["FilterDatumTol"]);         
        }
        else{
            unset($_SESSION[$this->_name]["FilterDatumTol"]);                                       
            unset($_SESSION[$this->_name]["FilterDatumIg"]);
		}
        if($this->getItemValue("FilterOldal"))                    
            $this->setWhereInput("banner_attr_oldal_id = ':item'", "FilterOldal");
        else
            unset($_SESSION[$this->_name]["FilterOldal"]);            
        if($this->getItemValue("FilterPozicio"))                    
            $this->setWhereInput("banner_pozicio = ':item'", "FilterPozicio");
        else
            unset($_SESSION[$this->_name]["FilterPozicio"]);            
        if($this->getItemValue("FilterStatus") == 1){                    
            $this->setWhereInput("banner_aktiv = 1 AND (NOW() BETWEEN banner_megjelenes AND banner_lejarat) OR (banner_megjelenes < NOW()) AND banner_lejarat = '0000-00-00 00:00:00'", "FilterStatus");            
        }
        elseif($this->getItemValue("FilterStatus") == 2){                    
            $this->setWhereInput("banner_aktiv = 0 OR banner_megjelenes > NOW() OR (banner_lejarat < NOW() AND banner_lejarat != '0000-00-00 00:00:00')", "FilterStatus");            
        }        
        else{
            unset($_SESSION[$this->_name]["FilterStatus"]);             
        }                                            
    }
}
?>