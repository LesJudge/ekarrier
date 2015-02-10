<?php
class NyelvSelect_Admin_Controller extends RimoController{
     public function __construct(){
        $this->__run();
    }
    
    public function __run(){
        $this->__loadModel("_Admin_Select");
        $this->_model->getNyelvek();
        $this->_model->modifyDefaultLang();
        parent::__run();
        $this->__show();
    }
    
	
	public function __show(){
        $this->_view->assign("nyelvek", $this->_model->getNyelvek());
        Rimo::$_site_frame->assign("Nyelv_Valaszto", $this->_view->fetch("modul/nyelv/view/admin.nyelv_select.tpl"));
    }
}
?>