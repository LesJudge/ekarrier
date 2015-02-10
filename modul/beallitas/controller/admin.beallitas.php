<?php
/**
 * @property Beallitas_Beallitas_Model $_model
 * @property Smarty $_view
 */
class Beallitas_Admin_Controller extends RimoController
{
        
        public $name='Beallitas';
        
        public function __construct()
        {
                $this->__loadModel('_Beallitas');
                $this->__addParams($this->_model->_params);
                $this->__run();
        }
        
        public function __show()
        {
                parent::__show();
                $features=$this->_model->findModuleFeatures();
                $this->_view->assign('features',$features);
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/beallitas/view/admin.beallitas_main.tpl'));
        }
        
}