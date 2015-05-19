<?php
include_once "page/admin/controller/admin.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class HirKategoriaedit_Admin_Controller extends Admin_Edit {
    public function __construct() {
        
       $this->_name = Rimo::$_config->KT_EDITFORM_NAME;
        $this->_model = $this->__loadPublicModel("hir","_Kategoria_Admin_Edit");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__addEvent("BtnDeleteMegtekintes", "DeleteMegtekintes");
        $this->__addEvent("BtnDeleteFile", "DeleteFile");
        $this->__run();
    }
    
    public function __runParams(){
        parent::__runParams();
        $this->_model->removeAccentsFromLink();
        $this->_model->removeDelimitterFromKulcsszo();
    }
    
    public function onClick_DeleteMegtekintes(){
        $this->_model->deleteMegtekintes();
        throw new Exception_Form_Message("Sikeresen törölte a megtekintések számát.");
    }
    
    public function __show(){
        parent::__show();
        $this->_view->assign("MODUL_NAME", Rimo::$_config->KT_MODUL_EDIT_NAME);
        $this->_view->assign("kep_max_size", Create::byte_converter($this->_params["File"]->_verify["maxsize"]));   
        Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/hir/view/admin.hirkategoria_edit.tpl"));
        //Rimo::$_site_frame->assign("Form", $this->__generateForm("modul/kategoria/view/admin.kategoria_edit.tpl"));
    }
    
    public function onLoad_Edit(){
        parent::onLoad_Edit();
        $this->_view->assign("no_view_parent",true); 
    }
    
    public function onClick_DeleteFile(){
        $this->_model->deleteKep($this->_events["BtnDeleteFile"]->_value);
        throw new Exception_Form_Message("Sikeresen törölte a képet.");
    }
}
?>