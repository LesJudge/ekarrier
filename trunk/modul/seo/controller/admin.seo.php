<?php
include_once "page/admin/controller/admin.list.php";
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Seo_Admin_Controller extends Admin_List
{

        public $_name='SeoList';

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
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/seo/view/admin.seo_list.tpl'));
        }

        public function onClick_Filter()
        {
                $nameFilter="seo_nev LIKE '%:item%' OR 
                                      seo_kulcs LIKE '%:item%' OR
                                      seo_leiras LIKE '%:item%' OR
                                      seo_meta_kulcsszo LIKE '%:item%'";
                $this->setWhereInput($nameFilter,'FilterSzuro');
                // Státusz filter
                $filterStatus=$this->getItemValue('FilterStatus');
                switch($filterStatus)
                {
                        case 1:
                                $this->setWhereInput('seo_aktiv=1','FilterStatus');
                                break;
                        case 2:
                                $this->setWhereInput('seo_aktiv=0','FilterStatus');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterStatus']);
                                break;
                }
        }

}