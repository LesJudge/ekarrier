<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
/**
 * Linktár Admin Edit controller.
 */
class LinktarEdit_Admin_Controller extends Admin_Edit{
    
    public $_name = 'LinktarEdit';
    
    public function __construct(){
        $this->__loadModel('_Edit');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    
    public function __runParams(){
        parent::__runParams();
    }
    
    public function __show(){
        parent::__show();   
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/linktar/view/admin.linktar_edit.tpl'));
    }
    
}
?>