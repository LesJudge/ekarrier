<?php
include_once "page/admin/controller/admin.list.php";

class NyelvSzotar_Admin_Controller extends Admin_List {
    public $_name = "NyelvSzotarList";
    
    public function __construct() {
        $this->__loadModel("_Szotar_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/nyelv/view/admin.nyelvszotar_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("nyelv_szotar_azon LIKE '%:item%' OR nyelv_szotar_szo LIKE '%:item%' ", "FilterSzuro");
        if($this->getItemValue("FilterModul"))
            $this->setWhereInput("modul_id=':item'", "FilterModul");
        else 
            unset($_SESSION[$this->_name]["FilterModul"]);
    }
}

?>