<?php
include_once "page/admin/controller/admin.list.php";

class HirlevelSikertelen_Admin_Controller extends Admin_List {
    public $_name = "HirlevelSikertelenList";
    protected $_multiple_lang = false;
    
    public function __construct() {
        $this->__loadModel("_Sikertelen_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hirlevel/view/admin.hirlevel_sikertelen_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("hirlevel_user.hirlevel_user_nev LIKE '%:item%' OR hirlevel_kikuldendo.hirlevel_user_email LIKE '%:item%' OR hirlevel_targy LIKE '%:item%'", "FilterSzuro");
        if($this->getItemValue("FilterHirlevel"))
            $this->setWhereInput("hirlevel_id=':item'", "FilterHirlevel");
        else 
            unset($_SESSION[$this->_name]["FilterHirlevel"]);
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
                $i++;
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_torles);
        }
    }
}
?>