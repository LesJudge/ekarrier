<?php
include_once "page/admin/controller/admin.list.php";
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Kompetencia_Admin_Controller extends Admin_List
{

        public $_name='KompetenciaList';

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
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/kompetencia/view/admin.kompetencia_list.tpl'));
        }

        public function onClick_Filter()
        {
                $nameFilter="kompetencia_nev LIKE '%:item%' OR 
                                      kompetencia_leiras LIKE '%:item%' OR
                                      kompetencia_tartalom LIKE '%:item%' OR
                                      kompetencia_meta_kulcsszo LIKE '%:item%'";
                $this->setWhereInput($nameFilter,'FilterSzuro');
                // Státusz filter
                $filterStatus=$this->getItemValue('FilterStatus');
                switch($filterStatus)
                {
                        case 1:
                                $this->setWhereInput('kompetencia_aktiv=1','FilterStatus');
                                break;
                        case 2:
                                $this->setWhereInput('kompetencia_aktiv=0','FilterStatus');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterStatus']);
                                break;
                }
        }

}