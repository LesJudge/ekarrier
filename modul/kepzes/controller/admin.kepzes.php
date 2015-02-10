<?php
require "page/admin/controller/admin.list.php";
/**
 * @property Kepzes_List_Model $_model Model.
 * @property Smarty $_view Smarty.
 */
class Kepzes_Admin_Controller extends Admin_List
{
    public $_name = 'AdminKepzesList';
    protected $_multiple_lang = false;

    public function __construct()
    {
        $this->__loadModel('_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/kepzes/view/admin.kepzes_list.tpl'));
    }
    
    public function onClick_Filter()
    {
        $this->setWhereInput("kepzes_nev LIKE '%:item%' OR kepzes_leiras LIKE '%:item%'", 'FilterSzuro');
        // Státusz filter
        $filterStatus = $this->getItemValue('FilterStatus');
        switch($filterStatus)
        {
            case 1:
                $this->setWhereInput('kepzes_aktiv = 1','FilterStatus');
                break;
            case 2:
                $this->setWhereInput('kepzes_aktiv = 0','FilterStatus');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterStatus']);
                break;
        }
    }
}