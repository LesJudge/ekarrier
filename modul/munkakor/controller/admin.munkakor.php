<?php
include_once "page/admin/controller/admin.list.php";
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Munkakor_Admin_Controller extends Admin_List
{

        public $_name='MunkakorList';

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
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/munkakor/view/admin.munkakor_list.tpl'));
        }

        public function onClick_Filter()
        {
                $nameFilter="munkakor_nev LIKE '%:item%' OR 
                                      munkakor_leiras LIKE '%:item%' OR
                                      munkakor_tartalom LIKE '%:item%' OR
                                      munkakor_meta_kulcsszo LIKE '%:item%'";
                $this->setWhereInput($nameFilter,'FilterSzuro');
                // Státusz filter
                $filterStatus=$this->getItemValue('FilterStatus');
                switch($filterStatus)
                {
                        case 1: 
                                $this->setWhereInput('munkakor_aktiv=1','FilterStatus');
                                break;
                        case 2: 
                                $this->setWhereInput('munkakor_aktiv=0','FilterStatus');
                                break;
                        default: 
                                unset($_SESSION[$this->_name]['FilterStatus']);
                                break;
                }
                // Kategória filter
                if($this->getItemValue('FilterKategoria'))
                        $this->setWhereInput('munkakor_attr_kategoria_id=:item','FilterKategoria');
                else
                        unset($_SESSION[$this->_name]['FilterKategoria']);
        }

}