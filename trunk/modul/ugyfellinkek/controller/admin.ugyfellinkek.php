<?php
include_once "page/admin/controller/admin.list.php";

class Ugyfellinkek_Admin_Controller extends Admin_List
{

        public $_name='UgyfellinkekList';

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
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/ugyfellinkek/view/admin.ugyfellinkek_list.tpl'));
        }

        public function onClick_Filter()
        {
                $nameFilter="link_nev LIKE '%:item%'";
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
                
                $filterChecked=$this->getItemValue('FilterChecked');
                switch($filterChecked)
                {
                        case 1:
                                $this->setWhereInput('checked = 0 AND tipus = "ugyfel"','FilterChecked');
                                break;
                        case 2:
                                $this->setWhereInput('checked = 1 AND tipus = "ugyfel"','FilterChecked');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterChecked']);
                                break;
                }
                
                $filterCat = $this->getItemValue('FilterCat');
                
             
          
             if(is_null($filterCat) || $filterCat == '')
                {
                    unset($_SESSION[$this->_name]['FilterCat']);
                }
                else
                {
                    $this->setWhereInput('category = "'.$filterCat.'"', 'FilterCat');
                } 
        
        
        }

}