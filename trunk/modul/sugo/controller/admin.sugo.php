<?php
include_once "page/admin/controller/admin.list.php";
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Sugo_Admin_Controller extends Admin_List
{

        public $_name='SugoList';

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
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/sugo/view/admin.sugo_list.tpl'));
        }

        public function onClick_Filter()
        {
                $nameFilter="sugo_nev LIKE '%:item%' OR sugo_tartalom LIKE '%:item%'";
                $this->setWhereInput($nameFilter,'FilterSzuro');
                // Státusz filter
                $filterStatus=$this->getItemValue('FilterStatus');
                switch($filterStatus)
                {
                        case 1:
                                $this->setWhereInput('sugo_aktiv=1','FilterStatus');
                                break;
                        case 2:
                                $this->setWhereInput('sugo_aktiv=0','FilterStatus');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterStatus']);
                                break;
                }
        }

}