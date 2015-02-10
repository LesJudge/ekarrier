<?php
include_once "page/admin/controller/admin.list.php";

class User_cim_Admin_Controller extends Admin_List {
    public $_name = "UserCimList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_List");
        parent::__construct();
        
        $this->__addParams($this->_model->_params);
        $user_id = mysql_real_escape_string($_REQUEST["user_id"]);
        $this->_model->listWhere["user_attr_user_id"] = "user_attr_user_id={$user_id}";
        $this->__run();
    }
    
    public function __run(){
    	if(!is_numeric(mysql_real_escape_string($_REQUEST["user_id"])))
			header("Location:".$_SERVER["PHP_SELF"]);
    	parent::__run();
    }
    
    public function __show(){
        parent::__show();
        $this->_view->assign("user_id",mysql_real_escape_string($_REQUEST["user_id"]));
        $this->_view->assign("tipusok",Rimo::$_config->CIM_TIPUS_EDIT);
        try{
        	$this->_view->assign("user_nev",$this->_model->getNev(mysql_real_escape_string($_REQUEST["user_id"])));
       	}catch(Exception_MYSQL $e){
       		header("Location:".$_SERVER["PHP_SELF"]);
       	}
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/user_cim/view/admin.user_cim_list.tpl"));
    }

    public function onClick_Filter() { 
        $this->setWhereInput("user_attr_cim_nev LIKE '%:item%' OR user_attr_cim_email LIKE '%:item%' OR user_attr_cim_tel LIKE '%:item%' OR user_attr_cim_fax LIKE '%:item%'", "FilterSzuro");
        if($this->getItemValue("FilterTipus")>0)
            $this->setWhereInput("user_attr_cim_tipus=:item", "FilterTipus");
        else 
            unset($_SESSION[$this->_name]["FilterTipus"]);
    }
}
?>