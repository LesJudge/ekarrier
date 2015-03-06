<?php
include_once "page/admin/controller/admin.list.php";

class Szakertovelemenye_Admin_Controller extends Admin_List
{

        public $_name='SzakertovelemenyeList';
        public $_multiple_lang = false;

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
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/szakertovelemenye/view/admin.szakertovelemenye_list.tpl'));
        }

        public function onClick_Filter()
        {
            
            $nameFilter="ugyf.vezeteknev LIKE '%:item%' OR ugyf.keresztnev LIKE '%:item%'";
                $this->setWhereInput($nameFilter,'FilterSzuro');
              
            
                // Státusz filter
                $filterStatus=$this->getItemValue('FilterStatus');
                switch($filterStatus)
                {
                        case 1:
                                $this->setWhereInput('megvalaszolva=1','FilterStatus');
                                break;
                        case 2:
                                $this->setWhereInput('megvalaszolva=0','FilterStatus');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterStatus']);
                                break;
                }
            
        }

}