<?php
require 'modul/seo/model/seo_Site_Model.php';
//require 'modul/infobox/model/infobox_Site_Model.php';
class PoziciotesztShow_Site_Controller extends RimoController {
    public $_name = "PoziciotesztShow";
    
    public function __construct() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->__loadModel("_Show");
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        try{
            if($_REQUEST["result"]){
                $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                $lId = Rimo::$_config->SITE_NYELV_ID;

                if(!isset($_REQUEST['view']) ||  $_REQUEST['view']!="1"){
                    $result = $this->_model->calcPoints($_REQUEST["kerdes"]);
                    $this->_model->saveResult(json_encode($_REQUEST["kerdes"]),$clientId,$result);
                }else{
                    $result = $this->_model->calcPoints(json_decode($_REQUEST["result"]));
                }
                        
                $this->_view->assign("result",$result);
                $topinfo = infobox_Site_Model::model()->findInfoboxItemByKey('positionTestTopInfobox',$lId);
                $this->_view->assign('topinfo',$topinfo);
                        
                try{
                    $leader = $this->_model->getLeaderDetails();
                    $employee = $this->_model->getEmployeeDetails();
                    $this->_view->assign("leader",$leader);
                    $this->_view->assign("employee",$employee);
                            
                    $this->_view->assign("leaderComps",$this->_model->getLeaderComps($leader['ID']));
                    $this->_view->assign("employeeComps",$this->_model->getEmployeeComps($employee['ID']));
                           
                }catch (Exception_MYSQL_Null_Rows $e){
                    throw new Exception_404();
                }
        
                $seo = seo_Site_Model::model()->getSeoItemByKey('positiontestEredmeny',$lId);
                Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/pozicioteszt/view/site.poziciotesztEredmeny_show.tpl'));    
            
            }else{
            
                try{
                    $lId = Rimo::$_config->SITE_NYELV_ID;
                    $this->_view->assign('questions',$this->_model->questions);
                        
                    $seo=seo_Site_Model::model()->getSeoItemByKey('positiontest',$lId);
                    Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                    Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                    Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                    Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                    Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/pozicioteszt/view/site.pozicioteszt_show.tpl'));
                }catch(Exception $e){
                }           
            }    
            }catch(Exception_MYSQL $e){
                throw new Exception_404();
            }
    }
}
?>