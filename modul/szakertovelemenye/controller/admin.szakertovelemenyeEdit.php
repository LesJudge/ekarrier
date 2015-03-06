<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';

class SzakertovelemenyeEdit_Admin_Controller extends Admin_Edit
{

        public $_name='SzakertovelemenyeEdit';
        public $_multiple_lang = false;
        
        public function __construct()
        {
                $this->__loadModel('_Edit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__run();
        }

        public function __show()
        {
                parent::__show();
                
                $compRajz = $this->_model->getCompRajz();
                if($compRajz === false){
                    $this->_view->assign('compRajz','0');
                }else
                {   
                    $this->_view->assign('compRajz',$compRajz);
                    $comps = $this->_model->getCompRajzCompetences($compRajz['ID']);
                    $this->_view->assign('comps',$comps);
                }
                
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/szakertovelemenye/view/admin.szakertovelemenye_edit.tpl'));
        }

        public function onLoad_Edit()
        {
            /*
                parent::onLoad_Edit();
                $this->_view->assign('szakertovelemenye_allapot',$this->_model->infoboxAllapot());
              */  
        }
        
       

}