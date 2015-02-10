<?php
include_once 'page/admin/controller/admin.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
//require 'modul/user_cim/model/UserAddressFinder.php';
require 'modul/cim/library/AddressFinder.php';

class CegTelephelyedit_Admin_Controller extends Admin_Edit
{

    public $_name = 'TelephelyEdit';

    public function __construct()
    {
        $this->__loadModel('_Telephely_Edit');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/ceg/view/admin.telephely_edit.tpl'));
    }

    public function onLoad_Edit()
    {
        parent::onLoad_Edit();
        $this->_view->assign('ceg_telephely_allapot', $this->_model->telephelyAllapot());
    }

}
