<?php
require 'modul/seo/model/seo_Site_Model.php';

class MunkavallaloEn_Site_Controller extends RimoController
{
        
        public function __construct()
        {
                if(!UserLoginOut_Site_Controller::$_id)
                {
                        throw new Exception_404;
                }
                $this->__run();
        }
        
        public function __show()
        {
                $config=Rimo::$_config;
                $routes=$config->routes;
                $lId=Rimo::$_config->SITE_NYELV_ID;
                // SEO
                $seo=seo_Site_Model::model()->getSeoItemByKey('mePage',$lId);
                
                $this->_view->assign('userData',UserLoginOut_Site_Controller::$userData);
                $this->_view->assign('routes',$routes);
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
                Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/munkavallalo/view/site.munkavallalo_en.tpl'));
        }
        
}