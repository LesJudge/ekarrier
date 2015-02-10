<?php
include_once 'page/all/controller/page.edit.php';
include_once 'page/admin/model/admin.edit_model.php';
require 'modul/user/library/UserHirlevelHelper.php';
require 'modul/user/library/model/BaseAdminUserEditModel.php';

class UserEdit_Admin_Controller extends Page_Edit
{
    public $_name = 'UserEdit';
    protected $_multiple_lang = false;
    
    public function __construct()
    {
        $this->__loadModel('_Edit');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
  
    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/user/view/admin.user_edit.tpl'));
    }
    
    public function __runEvents()
    {
        if(UserLoginOut_Controller::$_id != 1 && $this->_model->modifyID == 1) {
            throw new Exception_Form_Error('Önnek nincs joga ezt a felhasználót módosítani!');
        }
        parent::__runEvents();
    }
    
    public function onClick_New()
    {
        $this->verifyInputItem($this->_model->verifyPw());
        parent::onClick_New();
    }
    
    public function onClick_Modify()
    {
        if($this->getItemValue('Password')) {
            $this->verifyInputItem($this->_model->verifyPw());
        }
        parent::onClick_Modify();
    }
}