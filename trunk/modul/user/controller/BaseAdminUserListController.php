<?php
class BaseAdminUserListController extends DynamicFiltersController
{
    public $_name = null;
    protected $_multiple_lang = false;
    protected $model = null;
    protected $view = null;
    
    public function __construct()
    {
        $this->__loadModel($this->model);
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show()
    {
        parent::__show();
        $this->beforeRender();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/user/view/' . $this->view));
    }
    
    protected function setDynamicFilters()
    {
        return true;
    }

    protected function beforeRender()
    {
        return true;
    }
    
    public function onClick_Filter()
    {
        parent::onClick_Filter();
        if(UserLoginOut_Controller::$_id != 1) {
            $this->_model->listWhere['user_id'] = 'user_id!=1';
        }
        $this->setWhereInput("user_fnev LIKE '%:item%' OR  CONCAT(user_vnev,' ', user_knev)  LIKE '%:item%'", 'FilterSzuro');
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
    
    protected function onClick_MultipleDelete()
    {
         UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
         if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try {
                    $this->_model->__modifyRowStatuszWithValue("torolt", $val, 1);
                    $this->_model->delHirlevelUser($val);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                $i++;
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_torles);
        }
    }
}