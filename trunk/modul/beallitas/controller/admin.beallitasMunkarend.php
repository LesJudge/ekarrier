<?php
require "page/admin/controller/admin.list.php";
/**
 * @property Beallitas_MunkarendList_Model $_model Model.
 * @property Smarty $_view Smarty.
 */
class BeallitasMunkarend_Admin_Controller extends Admin_List
{
    public $_name = 'AdminBeallitasMunkarendList';
    protected $_multiple_lang = false;

    public function __construct()
    {
        $this->__loadModel('_MunkarendList');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign(
            'Form',
            $this->__generateForm('modul/beallitas/view/admin.beallitas_munkarend_list.tpl')
        );
    }
    
    public function onClick_Filter()
    {
        $this->setWhereInput("nev LIKE '%:item%'", 'FilterSzuro');
        // Státusz filter
        $filterStatus = $this->getItemValue('FilterStatus');
        switch($filterStatus)
        {
            case 1:
                $this->setWhereInput('munkarend_aktiv = 1','FilterStatus');
                break;
            case 2:
                $this->setWhereInput('munkarend_aktiv = 0','FilterStatus');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterStatus']);
                break;
        }
    }
}