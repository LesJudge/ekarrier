<?php
include_once "page/admin/controller/admin.list.php";

class Ceg_Admin_Controller extends Admin_List
{

    public $_name = 'CegList';
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
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/ceg/view/admin.ceg_list.tpl'));
    }
    public function onClick_Filter()
    {
        /*
        $nameFilter = "ceg_nev LIKE '%:item%' OR 
                                      ceg_leiras LIKE '%:item%' OR
                                      ceg_tartalom LIKE '%:item%' OR
                                      ceg_meta_kulcsszo LIKE '%:item%'";
        */
         $nameFilter = "nev LIKE '%:item%' OR 
                                      leiras LIKE '%:item%' OR
                                      tartalom LIKE '%:item%' OR
                                      meta_kulcsszo LIKE '%:item%'";
        
        $this->setWhereInput($nameFilter, 'FilterSzuro');
         
        
        
        // Státusz filter
        $filterStatus = $this->getItemValue('FilterStatus');
        switch ($filterStatus) {
            case 1:
                $this->setWhereInput('ceg_aktiv=1', 'FilterStatus');
                break;
            case 2:
                $this->setWhereInput('ceg_aktiv=0', 'FilterStatus');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterStatus']);
                break;
        }
    }
}