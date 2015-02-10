<?php
include_once 'page/admin/controller/admin.list.php';
require 'modul/munkakor/controller/MKLAdminController.php';
require 'modul/munkakor/model/munkakor_TartKieg_List_Model.php';
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class MunkakorElvarasokkiegeszites_Admin_Controller extends MKLAdminController
{
        
        public $_name='MunkakorElvarasokkiegeszitesList';

        public function __construct()
        {
                $this->__loadModel('_ElvKieg_List');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__run();
        }
        
        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/munkakor/view/admin.munkakor_elvarasok_kiegeszites_list.tpl'));
        }
        
}