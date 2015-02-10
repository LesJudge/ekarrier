<?php
include_once "page/admin/controller/admin.list.php";

class Sablon_Admin_Controller extends Admin_List {
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->_model = $this->__loadPublicModel("sablon", "_List");
        parent::__construct();
        
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        $this->_view->assign("MODUL_NAME", Rimo::$_config->SB_MODUL_LIST_NAME);
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/sablon/view/admin.sablon_list.tpl"));
    }

    public function onClick_Filter() {
        $this->_model->listWhere["sablon_tipus"] = "sablon_tipus='".Rimo::$_config->SABLON_TYPE."'";
        $this->setWhereInput("sablon_nev LIKE '%:item%'", "FilterSzuro");
    }
}
?>