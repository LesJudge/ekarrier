<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
require 'modul/cim/library/AddressFinder.php';
require 'modul/user/library/model/BaseAdminUserEditModel.php';
require 'library/uniweb/modul/ModelEditHelper.php';
require 'library/uniweb/AttachedUserInterface.php';
require 'library/uniweb/AttachedUser.php';
require 'library/uniweb/AttachedUserInsertInterface.php';
require 'library/uniweb/AttachedUserInsert.php';
require 'library/uniweb/AttachedUserUpdateInterface.php';
require 'library/uniweb/AttachedUserUpdate.php';
require 'library/uniweb/AttachedUserFinderInterface.php';
require 'library/uniweb/AttachableUserModelInterface.php';
require 'library/uniweb/AttachableUserModelAbstract.php';
require 'modul/ceg/library/SiteCegEditInsert.php';
require 'modul/ceg/library/SiteCegEditUpdate.php';
require 'modul/ceg/library/SiteCegEditFinder.php';

class CegEdit_Admin_Controller extends Admin_Edit
{

    public $_name = 'CegmEdit';
    public $_multiple_lang = false;
    
    public function __construct()
    {
        $this->__loadModel('_Edit');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__addEvent('BtnDeleteMegtekintes', 'DeleteMegtekintes');
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
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/ceg/view/admin.ceg_edit.tpl'));
    }
    public function onClick_DeleteMegtekintes()
    {
        $this->_model->deleteMegtekintes();
        throw new Exception_Form_Message('Sikeresen törölte a megtekintések számát.');
    }
    public function onLoad_Edit()
    {
        parent::onLoad_Edit();
        $this->_view->assign('ceg_allapot', $this->_model->cegAllapot());
    }
}