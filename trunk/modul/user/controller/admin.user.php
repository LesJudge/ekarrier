<?php
include_once "page/admin/controller/admin.list.php";
require 'library/uniweb/DynamicFiltersController.php';
require 'library/uniweb/DynamicFiltersModel.php';
/**
 * @property User_List_Model $_model Model.
 * @property Smarty $_view Smarty View.
 */
class User_Admin_Controller extends \DynamicFiltersController
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'AdminUserList';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;
    /**
     * Konstruktor.
     */
    public function __construct()
    {
        $this->__loadModel('_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    /**
     * Dinamikus szűrők beállítása.
     */
    protected function setDynamicFilters()
    {
        // Dinamikus szűrők beállítása.
    }
    /**
     * Form renderelése.
     */
    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/user/view/admin.user_list.tpl'));
    }
    /**
     * Szűrő
     */
    public function onClick_Filter()
    {
        parent::onClick_Filter();
        if(UserLoginOut_Controller::$_id != 1) {
            $this->_model->listWhere['user_id'] = 'user.user_id != 1';
        }
        $this->setWhereInput("user.user_fnev LIKE '%:item%' OR  CONCAT(user.user_vnev,' ', user.user_knev)  LIKE '%:item%'", 'FilterSzuro');
        if ($this->getItemValue('FilterStatus') == 1) {
            $this->setWhereInput('user_aktiv=1 AND user_megerositve=1', 'FilterStatus');
        }
        elseif ($this->getItemValue("FilterStatus") == 2) {
            $this->setWhereInput('user_aktiv=0 OR user_megerositve=0', 'FilterStatus');
        }
        else {
            unset($_SESSION[$this->_name]['FilterStatus']);
        }
    }
}