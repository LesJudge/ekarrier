<?php
include_once "page/admin/controller/admin.list.php";

class Email_Admin_Controller extends Admin_List {
    public $_name = "EmailList";
    
    public function __construct() {
        $this->__loadModel("_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/email/view/admin.email_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("email_felado_nev LIKE '%:item%' OR email_felado_email LIKE '%:item%' OR email_targy LIKE '%:item%' OR email_tartalom LIKE '%:item%'", "FilterSzuro");
    }
}
?>