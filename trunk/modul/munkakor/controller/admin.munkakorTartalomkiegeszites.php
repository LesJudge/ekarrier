<?php
include_once 'page/admin/controller/admin.list.php';
require 'modul/munkakor/controller/MKLAdminController.php';
/**
 * @property Munkakor_MunkakorTartalomKiegeszites_List_Model $_model
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class MunkakorTartalomkiegeszites_Admin_Controller extends MKLAdminController
{

        public $_name='MunkakorTartalomkiegeszitesList';

        public function __construct()
        {
                $this->__loadModel('_TartKieg_List');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__run();
        }
        
        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/munkakor/view/admin.munkakor_tartalom_kiegeszites_list.tpl'));
        }

}