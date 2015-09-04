<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
require 'modul/munkakor/model/MkAdminEditBaseModel.php';
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class KompetenciaEdit_Admin_Controller extends Admin_Edit
{

        public $_name='KompetenciamEdit';

        public function __construct()
        {
                $this->__loadModel('_Edit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__addEvent('BtnDeleteMegtekintes','DeleteMegtekintes');
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
                
                if($this->_model->modifyID && $this->_model->_params['TxtTipus']->_value == 'ugyfel'){
                    $this->_model->_params['TxtLink']->_value = "sajat".$this->_model->modifyID;
                    $this->_model->_params['TxtLeiras']->_value = "sajat";
                    $this->_model->_params['TxtKulcsszo']->_value = ",sajat,";
                    $this->_model->_params['TxtTartalom']->_value = "sajat";
                    //$this->_model->_params['TxtSzinkod']->_value = "";
                    $this->_view->assign('ugyf','1');
                    
                }
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/kompetencia/view/admin.kompetencia_edit.tpl'));
        }

        public function onClick_DeleteMegtekintes()
        {
                $this->_model->deleteMegtekintes();
                throw new Exception_Form_Message('Sikeresen törölte a megtekintések számát.');
        }

        public function onLoad_Edit()
        {
                parent::onLoad_Edit();
                $this->_view->assign('kompetencia_allapot',$this->_model->kompetenciaAllapot());
        }
        
        

}