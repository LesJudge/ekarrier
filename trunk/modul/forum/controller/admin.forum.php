<?php
include_once "page/admin/controller/admin.list.php";

class Forum_Admin_Controller extends Admin_List {
    public $_name = "ForumList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/forum/view/admin.forum_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("forum_targy LIKE '%:item%' OR forum_bekuldo LIKE '%:item%' OR forum_tartalom LIKE '%:item%'", "FilterSzuro");
        if($this->getItemValue("FilterNyelv"))
            $this->setWhereInput("forum_nyelv=:item", "FilterNyelv");
        else 
            unset($_SESSION[$this->_name]["FilterNyelv"]);
    }   
}
?>