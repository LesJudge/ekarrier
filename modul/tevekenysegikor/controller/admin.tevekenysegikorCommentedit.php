<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class TevekenysegikorCommentedit_Admin_Controller extends Admin_Edit
{

        public $_name='TevekenysegikorCommentedit';
        public $_multiple_lang = false;

        public function __construct()
        {
                $this->__loadModel('_Comment_Edit');
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
                
                $relatedInfo = $this->_model->getRelatedInfo($this->_model->_params['TxtType']->_value,$this->_model->_params['TxtTevkorID']->_value);
                $this->_view->assign('relatedInfo',$relatedInfo);
                
                $tevkorDesc = $this->_model->getTevkorDescription();
                $this->_view->assign('tevkorDesc',$tevkorDesc);
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/tevekenysegikor/view/admin.tevekenysegikor_comment_edit.tpl'));
        }

        

        public function onLoad_Edit()
        {
                parent::onLoad_Edit();
                
        }

}