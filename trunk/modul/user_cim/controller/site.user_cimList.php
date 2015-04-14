<?php
include_once "page/admin/controller/admin.list.php";

class User_cimList_Site_Controller  extends Page_List {
    public $_name = "UserCimSiteList";
    protected $_multiple_lang = false;
    
    public function __construct() {
    	define("LANG_PageList_nincs_elem", "Önnek jelenleg még nincs rögzítve címe.");
        $this->__loadModel("_List");
        parent::__construct();
        $this->__addEvent("BtnMultipleDelete", "MultipleDelete");
        $this->__addParams($this->_model->_params);
        $this->_model->listWhere["user_attr_user_id"] = "user_attr_user_id=".UserLoginOut_Controller::$_id."";
        $this->__run();
    }
    
    public function __run(){
    	if(!UserLoginOut_Controller::$_id)
			header("Location:".$_SERVER["PHP_SELF"]);
    	parent::__run();
    }
    
    public function __show(){
        parent::__show();
        $this->_view->assign("tipusok",Rimo::$_config->CIM_TIPUS_EDIT);
        $this->_view->assign("user_id",UserLoginOut_Controller::$_id);
        $this->_view->assign("Fejlec", $this->_model->tableHeader);
        try{
        	$this->_view->assign("user_nev",$this->_model->getNev(UserLoginOut_Controller::$_id));
       	}catch(Exception_MYSQL $e){
       		header("Location:".$_SERVER["PHP_SELF"]);
       	}
       	Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>"Címek")));
        Rimo::$_site_frame->assign("PageName", "Címek");
        Rimo::$_site_frame->assign("site_title","Címek");
        Rimo::$_site_frame->assign("site_description","Címek");
        Rimo::$_site_frame->assign("site_keywords","Címek");
        Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/user_cim/view/site.user_cim_list.tpl"));
    }
    
    protected function onClick_MultipleDelete(){
         if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try {
                    $this->_model->__modifyRowStatuszWithValue("torolt", $val, 1);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                $i++;
            }
            throw new Exception_Form_Message("$i Tétel sikeresen törölve");
        }
    }
}
?>