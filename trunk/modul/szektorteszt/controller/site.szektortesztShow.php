<?php
require 'modul/seo/model/seo_Site_Model.php';
//require 'modul/infobox/model/infobox_Site_Model.php';
class SzektortesztShow_Site_Controller extends RimoController {
    public $_name = "SzektortesztShow";
    
    public function __construct() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->__loadModel("_Show");
        $this->__run();
    }
    
    public function __show(){
        parent::__show();

            if($_REQUEST["finalResults"]){
                    try{
                        
                        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        $lId = Rimo::$_config->SITE_NYELV_ID;

                        $finalResArr = $this->_model->getFinal($_REQUEST["finalResults"]);
                        $this->_view->assign("Scores",$finalResArr);
                        
                        $MainResKat = $this->_model->getMainResKat();
                        $this->_view->assign("MainResKat",$MainResKat);
                        
                        $Kompetenciak = $this->_model->getKompetenciak();
                        $this->_view->assign("Kompetenciak",$Kompetenciak);
                        
                        if(!isset($_REQUEST['view']) ||  $_REQUEST['view']!="1")
                        {
                            $compSaver = Rimo::__loadPublic('model', 'kompetencia_SiteEdit', 'kompetencia');
                            foreach ($finalResArr[0]['kompetencia'] as $key=>$value){
                                $compSaver->addCompFromTest($key,1,$clientId);
                            }
                            $compSaver->addSzektorFromTest($finalResArr[0]['szektor_id'],$clientId,$_REQUEST["finalResults"]);
                        }
                        
                        $topinfo = infobox_Site_Model::model()->findInfoboxItemByKey('sectorTestTopInfobox',$lId);
                        $this->_view->assign('topinfo',$topinfo);

                        $bottominfo = infobox_Site_Model::model()->findInfoboxItemByKey('sectorTestBottomInfobox',$lId);
                        $this->_view->assign('bottominfo',$bottominfo);
                        
                        $seo=seo_Site_Model::model()->getSeoItemByKey('sectortestEredmeny',$lId);
                        Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/szektorteszt/view/site.szektortesztEredmeny_show.tpl'));
                    }catch(Exception_MYSQL $e){
                        throw new Exception_404();
                    }
                }else{
                    try{
                        $lId = Rimo::$_config->SITE_NYELV_ID;
                        $FirstKat = $this->_model->getFirstKat();
                        $SecondKat = $this->_model->getSecondKat();
                        $MainResKat = $this->_model->getMainResKat();
                        $Rules = $this->_model->getRules();
                        $Rules2 = $this->_model->getRules2();
                        $Multips = $this->_model->getMultips();
                        $this->_view->assign("FirstKat",$FirstKat);
                        $this->_view->assign("SecondKat",$SecondKat);
                        $this->_view->assign("MainResKat",$MainResKat);
                        $this->_view->assign("Rules",$Rules);
                        $this->_view->assign("Rules2",$Rules2);
                        $this->_view->assign("Multips",$Multips);
                        
                        $pointsZero = infobox_Site_Model::model()->findInfoboxItemByKey('sectorTestPointsZeroInfobox',$lId);
                        $this->_view->assign('pointsZero',$pointsZero);
                        
                        $orderFail = infobox_Site_Model::model()->findInfoboxItemByKey('sectorTestOrderFailInfobox',$lId);
                        $this->_view->assign('orderFail',$orderFail);
                        
                        $pointsRemaining = infobox_Site_Model::model()->findInfoboxItemByKey('sectorTestpointsRemainingInfobox',$lId);
                        $this->_view->assign('pointsRemaining',$pointsRemaining);
                        
                        $seo = seo_Site_Model::model()->getSeoItemByKey('sectortest',$lId);
                        Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/szektorteszt/view/site.szektorteszt_show.tpl'));
                    } catch(Exception_MYSQL $e)
                    {
                        throw new Exception_404();
                    }
                }   
    }
}
?>