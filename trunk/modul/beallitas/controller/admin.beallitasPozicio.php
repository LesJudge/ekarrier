<?php
include_once "page/admin/controller/admin.list.php";

class BeallitasPozicio_Admin_Controller extends Admin_List
{

        public $_name='PozicioList';

        public function __construct()
        {
                $this->__loadModel('_PozicioList');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__run();
        }

        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/beallitas/view/admin.beallitas_pozicio_list.tpl'));
        }

        public function onClick_Filter()
        {
                $nameFilter="pozicio_nev LIKE '%:item%'";
                $this->setWhereInput($nameFilter,'FilterSzuro');
                // Státusz filter
                $filterStatus=$this->getItemValue('FilterStatus');
                switch($filterStatus)
                {
                        case 1:
                                $this->setWhereInput('pozicio_aktiv=1','FilterStatus');
                                break;
                        case 2:
                                $this->setWhereInput('pozicio_aktiv=0','FilterStatus');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterStatus']);
                                break;
                }
        }

}