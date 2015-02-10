<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
require 'modul/munkakor/model/munkakor_TartKieg_Edit_Model.php';
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class MunkakorElvarasokkiegeszitesedit_Admin_Controller extends Admin_Edit
{

        public $_name='ElvarasokKiegeszitesEdit';

        public function __construct()
        {
                $this->__loadModel('_ElvKieg_Edit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__run();
        }

        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/munkakor/view/admin.munkakor_elvarasok_kiegeszites_edit.tpl'));
        }

}