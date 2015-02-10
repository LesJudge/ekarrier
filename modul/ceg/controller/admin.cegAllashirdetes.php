<?php
include_once "page/admin/controller/admin.list.php";

class CegAllashirdetes_Admin_Controller extends Admin_List
{

    public $_name = 'AllahirdetesList';
    protected $_multiple_lang = false;

    public function __construct()
    {
        $this->__loadModel('_Allashirdetes_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/ceg/view/admin.allashirdetes_list.tpl'));
    }
    public function onClick_Filter()
    {
        $nameFilter = "megnevezes LIKE '%:item%' OR
                                      ismerteto LIKE '%:item%'";
        $this->setWhereInput($nameFilter, 'FilterSzuro');
        // Státusz filter
        $filterStatus = $this->getItemValue('FilterStatus');
        switch ($filterStatus) {
            case 1:
                $this->setWhereInput('allashirdetes_aktiv=1', 'FilterStatus');
                break;
            case 2:
                $this->setWhereInput('allashirdetes_aktiv=0', 'FilterStatus');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterStatus']);
                break;
        }
        // Cég filter
        $filterCeg = (int) $this->getItemValue('FilterCeg');
        if ($filterCeg) {
            $this->setWhereInput('c.ceg_id=' . $filterCeg, 'FilterCeg');
        } else {
            unset($_SESSION[$this->_name]['FilterCeg']);
        }
        // Ellenőrzött szűrő
        $filterEllenorzott = (int) $this->getItemValue('FilterEllenorzott');
        if ($filterEllenorzott < 2) {
            $this->setWhereInput('ellenorzott=' . $filterEllenorzott, 'FilterEllenorzott');
        } else {
            unset($_SESSION[$this->_name]['FilterEllenorzott']);
        }
    }
}