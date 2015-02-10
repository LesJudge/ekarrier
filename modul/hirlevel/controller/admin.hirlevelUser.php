<?php
include_once "page/admin/controller/admin.list.php";

class HirlevelUser_Admin_Controller extends Admin_List {
    public $_name = "HirlevelUserList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_User_List");
        parent::__construct();
        
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hirlevel/view/admin.hirleveluser_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("hirlevel_user_nev LIKE '%:item%' OR hirlevel_user_email LIKE '%:item%'", "FilterSzuro");
        $tipus = $this->getItemValue("FilterTipus");
        if($tipus==1)
            $this->setWhereInput("user_id>0", "FilterTipus");
        elseif($tipus==2)
            $this->setWhereInput("user_id=0", "FilterTipus");
        elseif($tipus==3)
            $this->setWhereInput("hirlevel_user_leiratkozva=0", "FilterTipus");
        elseif($tipus==4)
            $this->setWhereInput("hirlevel_user_leiratkozva=1", "FilterTipus");
        else 
            unset($_SESSION[$this->_name]["FilterTipus"]);
        if($this->getItemValue("FilterKapcsolat"))
            $this->setWhereInput("hirlevel_nyelv_id_id=':item'", "FilterKapcsolat");
        else 
            unset($_SESSION[$this->_name]["FilterKapcsolat"]);
    }
    
    protected function onClick_MultipleDelete(){
         UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
         if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try {
                    $this->_model->deleteRow($val);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                try{
                    $this->_model->updateUser($val);
                }catch(Exception_MYSQL $e){           
                }
                $i++;
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_torles);
        }
    }
}
?>