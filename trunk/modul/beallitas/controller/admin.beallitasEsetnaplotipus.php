<?php
/**
 * @property Beallitas_EsetnaploTipusList_Model $_model Model.
 * @property Smarty $_view View.
 */
class BeallitasEsetnaplotipus_Admin_Controller extends Admin_List
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'AdminBeallitasEsetnaploTipus';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;

    public function __construct()
    {
        $this->__loadModel('_EsetnaploTipusList');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign(
            'Form',
            $this->__generateForm('modul/beallitas/view/admin.beallitas_ugyfel_esetnaplo_tipus_list.tpl')
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
                $this->setWhereInput('ugyfel_esetnaplo_tipus_aktiv = 1','FilterStatus');
                break;
            case 2:
                $this->setWhereInput('ugyfel_esetnaplo_tipus_aktiv = 0','FilterStatus');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterStatus']);
                break;
        }
    }
}