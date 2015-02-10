<?php
require "page/admin/controller/admin.list.php";

class NyelvtudasSzint_Admin_Controller extends Admin_List
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'AdminNyelvtudasSzintList';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;

    public function __construct()
    {
        $this->__loadModel('_SzintList');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign(
            'Form',
            $this->__generateForm('modul/nyelvtudas/view/admin.nyelvtudas_szint_list.tpl')
        );
    }
    
    public function onClick_Filter()
    {
        $this->setWhereInput("nyelvtudas_szint_nev LIKE '%:item%'", 'FilterSzuro');
        // Státusz filter
        $filterStatus = $this->getItemValue('FilterStatus');
        switch($filterStatus)
        {
            case 1:
                $this->setWhereInput('nyelvtudas_szint_aktiv = 1','FilterStatus');
                break;
            case 2:
                $this->setWhereInput('nyelvtudas_szint_aktiv = 0','FilterStatus');
                break;
            default:
                unset($_SESSION[$this->_name]['FilterStatus']);
                break;
        }
    }
}