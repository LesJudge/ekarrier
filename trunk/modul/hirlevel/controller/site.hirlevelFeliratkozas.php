<?php
include_once "page/all/controller/page.edit.php";
include_once "page/admin/model/admin.edit_model.php";

class HirlevelFeliratkozas_Site_Controller extends Page_Edit {
    public $_name = "HirlevelFeliratkozas";
    private $tartalom_show_model = "";
    
    public function __construct() {
        $this->__loadModel("_Feliratkozas");
        parent::__construct();
        // DEBUG
        //unset($this->_model->modifyID);
        $this->_model->modifyID=null;
        // END DEBUG
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, "BtnSave", $this->_name));
        $this->tartalom_show_model = $this->__loadPublicModel("tartalom","_Show");
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        try{
            $data = $this->tartalom_show_model->getTartalomFromID(2);
            $this->_view->assign("data",$data);
            Rimo::$_site_frame->assign("HirlevelFeliratkozas", $this->__generateForm("modul/hirlevel/view/site.hirlevelfeliratkozas.tpl"));  
        }
        catch(Exception_MYSQL $e){
            throw new Exception_404();
        }
    }
    
    public function onClick_New(){
        try{
            parent::onClick_New();
        }
        catch(Exception_Form_Message $e){
        	throw new Exception_Form_Message(Create::getSzotarUzenet($this->_model->_DB,"sikeres_hirlevel_feliratkozas",8,Rimo::$_config->SITE_NYELV_ID));
        }
    }
}
?>