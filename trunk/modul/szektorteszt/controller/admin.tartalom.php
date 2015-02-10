<?php
include_once "page/admin/controller/admin.list.php";

class Tartalom_Admin_Controller extends Admin_List {
    public $_name = "TartalomList";
    
    public function __construct() {
        $this->__loadModel("_List");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/tartalom/view/admin.tartalom_list.tpl"));
    }

    public function onClick_Filter() {
        $this->setWhereInput("tartalom_cim LIKE '%:item%' OR tartalom_leiras LIKE '%:item%' OR tartalom_tartalom LIKE '%:item%' OR tartalom_szerzo LIKE '%:item%' OR tartalom_meta_kulcsszo LIKE '%:item%'", "FilterSzuro");
    }
    
    protected function onClick_Publish(){
        $this->_model->updateMenuStatusz($this->_events["BtnPublish"]->_value,1);
        parent::onClick_Publish();
    }
    
    protected function onClick_Unpublish(){
        $this->_model->updateMenuStatusz($this->_events["BtnUnpublish"]->_value,0);
        parent::onClick_Unpublish();
    }
    
    protected function onClick_MultipleDelete(){
        UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
        if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try {
                    $this->_model->deleteRow($val);
                    $i++;
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_torles);
        }
    }
    
    protected function onClick_MultiplePublish(){
        if(is_array($this->_params["SelRow"]->_value)){
            foreach($this->_params["SelRow"]->_value as $val){
                try{
                    $this->_model->updateMenuStatusz($val, 1);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
            }
        }
        parent::onClick_MultiplePublish();
    }
    
    protected function onClick_MultipleUnpublish(){
        if(is_array($this->_params["SelRow"]->_value)){
            foreach($this->_params["SelRow"]->_value as $val){
                try{
                    $this->_model->updateMenuStatusz($val, 0);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
            }
        }
       parent::onClick_MultipleUnpublish();
    }
}
?>