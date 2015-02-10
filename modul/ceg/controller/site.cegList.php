<?php
require 'page/admin/controller/admin.list.php';
require 'modul/seo/model/seo_Site_Model.php';

class CegList_Site_Controller extends Admin_List
{
        
        public $_name='CegList';
        protected $_multiple_lang=false;


        public function __construct()
        {
                defined(LANG_PageList_nincs_elem) or define(LANG_PageList_nincs_elem,'Nincs megjeleníthető munkáltató');

                $this->__loadModel('_SiteList');
                //$this->_model->listWhere[]='u.user_megerositve=1';
                parent::__construct(Rimo::$_config->SITE_NYELV_ID);
                $this->__addParams($this->_model->_params);
                $this->__run();
        }
        
        public function __show()
        {
                parent::__show();
                $lId=Rimo::$_config->SITE_NYELV_ID;
                $seo=seo_Site_Model::model()->getSeoItemByKey('employers',$lId);
                Rimo::$_site_frame->assign('Indikator',array(
                        1=>array(
                                'nev'=>$seo['seo_nev'],
                        )
                ));
                Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/ceg/view/site.ceg_list.tpl'));
        }
        
        public function onClick_Filter()
        {
                //$nameFilter="ceg_nev LIKE '%:item%'";
                $nameFilter="nev LIKE '%:item%'";
                $this->setWhereInput($nameFilter,'FilterSzuro');
                
                $filterCity=$this->getItemValue('FilterCity');
                if($filterCity)
                {
                        //$this->setWhereInput("uac.user_attr_cim_varos LIKE '%:item%'",'FilterCity');
                    $this->setWhereInput("cim_varos.cim_varos_nev LIKE '%:item%'",'FilterCity');
                }
                else
                {
                        unset($_SESSION[$this->_name]['FilterCity']);
                }
                
                $filterSector=$this->getItemValue('FilterSector');
                
                if($filterSector && $filterSector!=-1)
                {
                    $this->setWhereInput("ceg_adatok.szektor_id=:item",'FilterSector');
                }
                else
                {
                        unset($_SESSION[$this->_name]['FilterSector']);
                }
                
                $filterMunkakor=$this->getItemValue('FilterMunkakor');
                
                if($filterMunkakor && $filterMunkakor!=-1)
                {
                    $this->setWhereInput("ceg_attr_munkakor.munkakor_id=:item",'FilterMunkakor');
                }
                else
                {
                       unset($_SESSION[$this->_name]['FilterMunkakor']);
                }
                
        }
        
}