<?php
include_once "page/admin/controller/admin.list.php";

class Nyelv_Admin_Controller extends Admin_List {
    public $_name = "NyelvList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/nyelv/view/admin.nyelv_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("nyelv_nev LIKE '%:item%' OR nyelv_azon LIKE '%:item%'", "FilterSzuro");
    }
}
?>