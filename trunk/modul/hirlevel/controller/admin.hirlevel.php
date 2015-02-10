<?php
include_once "page/admin/controller/admin.list.php";

class Hirlevel_Admin_Controller extends Admin_List {
    public $_name = "HirlevelList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hirlevel/view/admin.hirlevel_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("hirlevel.hirlevel_targy LIKE '%:item%' OR hirlevel.hirlevel_felado_nev LIKE '%:item%' OR hirlevel.hirlevel_felado_email LIKE '%:item%' ", "FilterSzuro");
        $tipus = $this->getItemValue("FilterTipus");
        if($tipus==1)
            $this->setWhereInput("hirlevel_kikuldve>0", "FilterTipus");
        elseif($tipus==2)
            $this->setWhereInput("hirlevel_lezarva=1", "FilterTipus");
        elseif($tipus==3)
            $this->setWhereInput("hirlevel_kikuldve>1 AND hirlevel.hirlevel_proba=0", "FilterTipus");
        elseif($tipus==4)
            $this->setWhereInput("hirlevel_kikuldve=0", "FilterTipus");
        elseif($tipus==5)
            $this->setWhereInput("hirlevel.hirlevel_proba=1", "FilterTipus");
        elseif($tipus==6)
            $this->setWhereInput("hirlevel.hirlevel_proba=0", "FilterTipus");
        else 
            unset($_SESSION[$this->_name]["FilterTipus"]);
    }
}
?>