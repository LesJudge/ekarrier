<?php
class Hir_Admin_Controller extends Admin_List {
    public $_name = "HirList";
    
    public function __construct() {
        $this->__loadModel("_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hir/view/admin.hir_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("hir_cim LIKE '%:item%' OR hir_leiras LIKE '%:item%' OR hir_tartalom LIKE '%:item%' OR hir_szerzo LIKE '%:item%' OR hir_meta_kulcsszo LIKE '%:item%'", "FilterSzuro");
        if($this->getItemValue("FilterStatus")==1)
            $this->setWhereInput("hir_aktiv=1 AND ((NOW() BETWEEN hir_megjelenes AND hir_lejarat) OR (hir_megjelenes<NOW() AND hir_lejarat='0000-00-00 00:00:00'))", "FilterStatus");
        elseif($this->getItemValue("FilterStatus")==2)
            $this->setWhereInput("hir_aktiv=0 OR hir_megjelenes>NOW() OR (hir_lejarat<NOW() AND hir_lejarat!='0000-00-00 00:00:00')", "FilterStatus");
        else 
            unset($_SESSION[$this->_name]["FilterStatus"]);
        if($this->getItemValue("FilterKategoria"))
            $this->setWhereInput("hir_attr_kategoria_id=:item", "FilterKategoria");
        else
            unset($_SESSION[$this->_name]["FilterKategoria"]);
    }
}
?>