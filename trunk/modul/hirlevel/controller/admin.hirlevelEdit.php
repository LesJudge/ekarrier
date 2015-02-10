<?php
include_once "page/all/controller/page.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class HirlevelEdit_Admin_Controller extends Page_Edit {
    public $_name = "HirlevelEdit";
    protected $_multiple_lang = false;
    public function __construct() {
        $this->__loadModel("_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    
    public function __show(){
        parent::__show();   
        $this->_view->assign("sablon",$this->_model->loadSablon());
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hirlevel/view/admin.hirlevel_edit.tpl"));
    }
    
    public function __verify(){
        parent::__verify();
        if($this->getItemValue("ChkProba")==0){
            $this->getItemObject("SelCsoport")->_verify["multiSelect"]=true;
            $this->verifyInputItem(array($this->_params["SelCsoport"]));
        }
    }
    
    public function onClick_Modify(){
        try{
            parent::onClick_Modify();
        }catch(Exception_Form_Message $e){
            $this->_view->assign("FormMessage", $e->getMessage());
            if($this->BtnSave->_value=="sendHirlevel"){
                $cimzettek_szama = $this->_model->insertKikuldendo();
                $this->_model->updateHirlevel($cimzettek_szama);
                throw new Exception_Form_Message($e->getMessage()." <br />Sikeres hírlevél ütemezés.");
            }    
        }
    }
    
    public function onClick_New(){
        try{
            parent::onClick_New();
        }catch(Exception_Form_Message $e){
            $this->_view->assign("FormMessage", $e->getMessage());
            if($this->BtnSave->_value=="sendHirlevel"){
                $cimzettek_szama = $this->_model->insertKikuldendo();
                $this->_model->updateHirlevel($cimzettek_szama);
                $this->formReset(true);
                $this->onLoad_New();
                throw new Exception_Form_Message($e->getMessage().". <br />Sikeres hírlevél ütemezés.");
            }
            else{
                $this->formReset(true);
                $this->onLoad_New();
            }
        }
    }
    
    public function formReset($torles=false) {
        if($torles)
            parent::formReset();
    }
}
?>