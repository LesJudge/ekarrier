<?php
include_once "page/admin/controller/admin.list.php";

class UserJogcsoport_Admin_Controller extends Admin_List {
    public $_name = "UserJogcsoportList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_Jogcsoport_List");
        parent::__construct();
        
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/user/view/admin.userjogcsoport_list.tpl"));
    }

    public function onClick_Filter() {
        if(UserLoginOut_Controller::$_id!=1)
            $this->_model->listWhere["jogcsoport_id"] = "jogcsoport_id!=1"; 
        $this->setWhereInput("jogcsoport_nev LIKE '%:item%'", "FilterSzuro");
        if($this->getItemValue("FilterTipus"))
            $this->setWhereInput("site_tipus_id=':item'", "FilterTipus");
        else 
            unset($_SESSION[$this->_name]["FilterTipus"]);
    }
}
?>