<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';

class BeallitasIparagedit_Admin_Controller extends Admin_Edit
{

        public $_name='IparagmEdit';

        public function __construct()
        {
                $this->__loadModel('_IparagEdit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__run();
        }

        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/beallitas/view/admin.beallitas_iparag_edit.tpl'));
        }

        public function onLoad_Edit()
        {
                parent::onLoad_Edit();
                $this->_view->assign('iparag_allapot',$this->_model->iparagAllapot());
        }

}