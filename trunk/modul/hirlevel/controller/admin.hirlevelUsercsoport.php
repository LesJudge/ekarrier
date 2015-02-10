<?php
include_once "page/admin/controller/admin.list.php";

class HirlevelUsercsoport_Admin_Controller extends Admin_List {
    public $_name = "HirlevelUserCsoportList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_Usercsoport_List");
        parent::__construct();
        
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hirlevel/view/admin.hirlevelusercsoport_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("hirlevel_csoport_nev LIKE '%:item%'", "FilterSzuro");
    }
    
    protected function onClick_MultipleDelete(){
         UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
         if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
            	if($val!=1){
	                try {
	                	if($this->_model->csoportTorolheto($val))
	                    	$this->_model->__modifyRowStatuszWithValue("torolt", $val, 1);
                 		else
                 			$i--;
	                }catch(Exception_MYSQL_Null_Affected_Rows $e){
	                }
	                $i++;
             	}
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_torles);
        }
    }
}
?>