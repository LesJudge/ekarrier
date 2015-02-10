<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class SugoEdit_Admin_Controller extends Admin_Edit
{

        public $_name='SugomEdit';

        public function __construct()
        {
                $this->__loadModel('_Edit');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addScript(Create::JQUERY_verify($this->_params,'BtnSave',$this->_name));
                $this->__addEvent('BtnDeleteMegtekintes','DeleteMegtekintes');
                $this->__run();
        }

        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form',$this->__generateForm('modul/sugo/view/admin.sugo_edit.tpl'));
        }

        public function onClick_DeleteMegtekintes()
        {
                $this->_model->deleteMegtekintes();
                throw new Exception_Form_Message('Sikeresen törölte a megtekintések számát.');
        }

        public function onLoad_Edit()
        {
                parent::onLoad_Edit();
                $this->_view->assign('sugo_allapot',$this->_model->sugoAllapot());
        }

}