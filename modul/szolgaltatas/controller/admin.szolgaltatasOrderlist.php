<?php
//require "page/admin/controller/admin.list.php";
/**
 * @property Szolgaltatas_List_Model $_model Model.
 * @property Smarty $_view Smarty.
 */
class SzolgaltatasOrderlist_Admin_Controller extends Admin_List
{
    public $_name = 'SzolgaltatasOrderlist';
    protected $_multiple_lang = false;

    public function __construct()
    {
        $this->__loadModel('_Order_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/szolgaltatas/view/admin.szolgaltatas_order_list.tpl'));
    }
    
    public function onClick_Filter()
    {
        $this->setWhereInput("c.nev LIKE '%:item%'", 'FilterSzuro');
        // Státusz filter
        $filterStatus = $this->getItemValue('FilterStatus');
        switch($filterStatus)
        {
            case 1:
                $this->setWhereInput('ceg_szolgaltatas_megrendeles_aktiv = 1','FilterStatus');
                break;
            case 2:
                $this->setWhereInput('ceg_szolgaltatas_megrendeles_aktiv = 0','FilterStatus');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterStatus']);
                break;
        }
        
        $filterOrderStatusz = $this->getItemValue('FilterOrderStatusz');
        switch($filterOrderStatusz)
        {
            case 1:
                $this->setWhereInput('statusz = 0','FilterOrderStatusz');
                break;
            case 2:
                $this->setWhereInput('statusz = 1','FilterOrderStatusz');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterOrderStatusz']);
                break;
        }
        
    }
}