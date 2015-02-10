<?php
require 'page/all/controller/page.list.php';
require 'modul/seo/model/seo_Site_Model.php';
/**
 * @property User_Vegzettseg_SiteList_Model $_model
 * @property Smarty $_view
 */
class MunkavallaloVegzettsegList_Site_Controller extends Page_List
{
        
        public $_name='VegzettsegList';
        protected $_multiple_lang=false;


        public function __construct()
        {
                UserLoginOut_Site_Controller::verifyJogcsoportAccess(2);
                defined(LANG_PageList_nincs_elem) or define(LANG_PageList_nincs_elem,'Nincs megjeleníthető végzettség!');
                $this->__loadModel('_Vegzettseg_List');
                //$this->_model->listWhere[]='user_id='.UserLoginOut_Site_Controller::$_id;
                $this->_model->listWhere[]='user_id=3';
                parent::__construct(Rimo::$_config->SITE_NYELV_ID);
                $this->__addParams($this->_model->_params);
                $this->__run();
        }
        
        public function __show()
        {
                parent::__show();
                $routes=Rimo::$_config->routes;
                $lId=Rimo::$_config->SITE_NYELV_ID;
                $seo=seo_Site_Model::model()->getSeoItemByKey('myQualifications',$lId);

                $this->_view->assign('routes',$routes);
                Rimo::$_site_frame->assign('Indikator',array(
                        1=>array(
                                'nev'=>'Profil',
                                'link'=>Rimo::$_config->DOMAIN.'profil/'
                        ),
                        2=>array('nev'=>$seo['seo_nev'])
                ));
                Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/munkavallalo/view/site.munkavallalo_vegzettseg_list.tpl'));
        }
        
}