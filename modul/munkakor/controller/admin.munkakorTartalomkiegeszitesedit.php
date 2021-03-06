<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
/**
 * @property Munkakor_TartKieg_Edit_Model $_model
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class MunkakorTartalomkiegeszitesedit_Admin_Controller extends Admin_Edit
{

        public $_name='MunkakorKiegeszitesEdit';

        public function __construct()
        {
                $this->__loadModel('_TartKieg_Edit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__run();
        }

        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/munkakor/view/admin.munkakor_tartalom_kiegeszites_edit.tpl'));
        }

}