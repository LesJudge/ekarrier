<?php
require "page/admin/controller/admin.list.php";
/**
 * @property Szolgaltatas_List_Model $_model Model.
 * @property Smarty $_view Smarty.
 */
class BeallitasPrograminformacio_Admin_Controller extends Admin_List
{
    public $_name = 'AdminBeallitasPrograminformacioList';
    protected $_multiple_lang = false;

    public function __construct()
    {
        $this->__loadModel('_PrograminformacioList');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign(
            'Form',
            $this->__generateForm('modul/beallitas/view/admin.beallitas_program_informacio_list.tpl')
        );
    }
    
    public function onClick_Filter()
    {
        $this->setWhereInput("program_informacio_nev LIKE '%:item%'", 'FilterSzuro');
        // Státusz filter
        $filterStatus = $this->getItemValue('FilterStatus');
        switch($filterStatus)
        {
            case 1:
                $this->setWhereInput('program_informacio_aktiv = 1','FilterStatus');
                break;
            case 2:
                $this->setWhereInput('program_informacio_aktiv = 0','FilterStatus');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterStatus']);
                break;
        }
    }
}