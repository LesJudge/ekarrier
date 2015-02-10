<?php
include_once "page/admin/controller/admin.list.php";

class CegTelephely_Admin_Controller extends Admin_List
{

        public $_name='TelephelyList';
        protected $_multiple_lang=false;

        public function __construct()
        {
                $this->__loadModel('_Telephely_List');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__run();
        }

        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/ceg/view/admin.telephely_list.tpl'));
        }

        public function onClick_Filter()
        {
                $nameFilter="c.nev LIKE '%:item%'";
                $this->setWhereInput($nameFilter, 'FilterSzuro');
                // Státusz filter
                $filterStatus=$this->getItemValue('FilterStatus');
                switch($filterStatus)
                {
                        case 1:
                                $this->setWhereInput('ceg_telephely_aktiv=1', 'FilterStatus');
                                break;
                        case 2:
                                $this->setWhereInput('ceg_telephely_aktiv=0', 'FilterStatus');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterStatus']);
                                break;
                }
                // Cég filter
                $filterCeg=(int)$this->getItemValue('FilterCeg');
                if($filterCeg)
                {
                        $this->setWhereInput('c.ceg_id='.$filterCeg,'FilterCeg');
                }
                else
                {
                        unset($_SESSION[$this->_name]['FilterCeg']);
                }
        }

}