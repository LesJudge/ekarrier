<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
require 'modul/ceg/model/AllashirdetesBaseEditModel.php';

class CegAllashirdetesedit_Admin_Controller extends Admin_Edit
{

        public $_name='AllashirdetesEdit';

        public function __construct()
        {
                $this->__loadModel('_Allashirdetes_Edit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__run();
        }

        public function __runParams()
        {
                parent::__runParams();
                $this->_model->removeAccentsFromLink();
                $this->_model->removeDelimitterFromKulcsszo();
        }

        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/ceg/view/admin.allashirdetes_edit.tpl'));
        }

        public function onLoad_Edit()
        {
                parent::onLoad_Edit();
                $this->_view->assign('allashirdetes_allapot',$this->_model->allashirdetesAllapot());
        }

}