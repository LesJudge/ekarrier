<?php
require 'modul/seo/model/seo_Site_Model.php';
require 'modul/sugo/model/sugo_Site_Model.php';

class ProfilIndex_Site_Controller extends RimoController
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
                $lId=Rimo::$_config->SITE_NYELV_ID;
                // SEO
                $seo=seo_Site_Model::model()->getSeoItemByKey('profilePage',$lId);
                // Súgó
                $sm=new sugo_Site_Model; // Súgó model
                $this->_view->assign('sugok',$sm->getRandomSugo(3)); // Lekérdez 3 random súgó elemet.
                // Template
                $view='site.profil_munkavallalo.tpl';
                if(isset(UserLoginOut_Site_Controller::$_rights['jogcsoport'][3]) && UserLoginOut_Site_Controller::$_rights['jogcsoport'][3]==3)
                {
                        $view='site.profil_munkaltato.tpl';
                }
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
                Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/profil/view/'.$view));
        }
        
}