<?php
require 'page/all/controller/page.list.php';
require 'modul/seo/model/seo_Site_Model.php';
require 'modul/infobox/model/infobox_Site_Model.php';
/**
 * @property Kompetencia_SiteList_Model $_model
 * @property Smarty $_view
 */
class KompetenciaList_Site_Controller extends Page_List
{
        
        public $_name='KompetenciaList';
        protected $_multiple_lang=false;
        
        public function __construct()
        {       
                $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                defined(LANG_PageList_nincs_elem) or define(LANG_PageList_nincs_elem,'Nincs megjeleníthető kompetencia!');
                $this->__loadModel('_SiteList');
                parent::__construct(Rimo::$_config->SITE_NYELV_ID);
                $this->_model->listWhere[]='kompetencia_aktiv=1';
                $this->__addParams($this->_model->_params);
                $this->__run();
        }
        
        public function __show()
        {
                parent::__show();
                $lId=Rimo::$_config->SITE_NYELV_ID;
                // SEO Query
                $seo=seo_Site_Model::model()->getSeoItemByKey('competences',$lId);
                // Infobox Query
                $topinfo=infobox_Site_Model::model()->findInfoboxItemByKey('competencesTopInfobox',$lId);
                $this->_view->assign('topinfo',$topinfo);
                // Render
                Rimo::$_site_frame->assign('Indikator',array(
                        1=>array(
                                'nev'=>$seo['seo_nev'],
                        )
                ));
                Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/kompetencia/view/site.kompetencia_list.tpl'));
        }
        
}