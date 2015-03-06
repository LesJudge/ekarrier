<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';

class UgyfeluzenetekEdit_Admin_Controller extends Admin_Edit
{

        public $_name='UgyfeluzenetekEdit';
        public $_multiple_lang = false;

        public function __construct()
        {
                $this->__loadModel('_Edit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__run();
        }

        public function __runParams()
        {
                parent::__runParams();

        }

        public function __show()
        {
                parent::__show();
                if($this->_model->modifyID){
                    $this->_view->assign('mod','1');
                }
                
                
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/ugyfeluzenetek/view/admin.ugyfeluzenetek_edit.tpl'));
        }

        

        public function onLoad_Edit()
        {
                parent::onLoad_Edit();
                
        }

}