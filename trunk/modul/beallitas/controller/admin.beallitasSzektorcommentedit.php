<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class BeallitasSzektorcommentedit_Admin_Controller extends Admin_Edit
{

        public $_name='BeallitasSzektorcommentedit';
        public $_multiple_lang = false;

        public function __construct()
        {
                $this->__loadModel('_Szektor_Comment_Edit');
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
                $secDesc = $this->_model->getSecDescription();
                $this->_view->assign('secDesc',$secDesc);
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/beallitas/view/admin.szektor_comment_edit.tpl'));
        }

        

        public function onLoad_Edit()
        {
                parent::onLoad_Edit();
                
        }

}