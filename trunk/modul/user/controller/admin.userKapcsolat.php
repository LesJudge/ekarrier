<?php
include_once "page/admin/controller/admin.list.php";
require 'library/uniweb/ar/ArBase.php';
require 'modul/user/model/ar/User.php';

class UserKapcsolat_Admin_Controller extends Admin_List
{

    public $_name = "UserKapcsolatList";
    protected $_multiple_lang = false;

    public function __construct()
    {
        $this->__loadModel("_KapcsolatList");
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/user/view/admin.user_kapcsolat_list.tpl'));
    }

    public function onClick_Filter()
    {
        if(UserLoginOut_Controller::$_id != 1)
        {
            $this->_model->listWhere["user_id"]="user_id!=1";
        }
        $this->setWhereInput("user_fnev LIKE '%:item%' OR  CONCAT(user_vnev,' ', user_knev)  LIKE '%:item%'", "FilterSzuro");

        $filterUser = (int)$this->getItemValue('FilterUser');
        if($filterUser > 0)
        {
            $this->setWhereInput('user_kapcsolat.user_id = '.$filterUser, 'FilterUser');
        }
        else
        {
            unset($_SESSION[$this->_name]['FilterUser']);
        }
    }

}