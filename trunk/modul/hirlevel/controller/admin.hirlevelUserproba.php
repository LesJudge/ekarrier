<?php
include_once "page/admin/controller/admin.list.php";

class HirlevelUserproba_Admin_Controller extends Admin_List {
    public $_name = "HirlevelUserProbaList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_Probauser_List");
        parent::__construct();
        
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hirlevel/view/admin.hirlevelprobauser_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("hirlevel_probauser_nev LIKE '%:item%' OR hirlevel_probauser_email LIKE '%:item%'", "FilterSzuro");
    }
}
?>