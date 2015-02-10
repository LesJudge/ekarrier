<?php
/**
 * @property Kompetencia_Show_Model $_model
 * @property Smarty $_view
 */
require 'modul/seo/model/seo_Site_Model.php';
require 'modul/infobox/model/infobox_Site_Model.php';

class KompetenciaEdit_Site_Controller extends Page_Edit
{
        
        public $_name='KompetenciaEdit';
        
        
        public function __construct()
        {
           
                
                $this->__loadModel('_SiteEdit');
                $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                $this->_model->setUserId(UserLoginOut_Site_Controller::$_id);
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addEvent('BtnDeleteComp','DeleteComp');
                $this->__addEvent('BtnEditComp','EditComp');
                $this->__addEvent('BtnAddComp','AddComp');
                $this->__run();
        }
        
        public function __show()
        {
                try
                {
                       
                        $lId=Rimo::$_config->SITE_NYELV_ID;
                        try{
                            $this->_view->assign('userCompetences',$this->_model->findCompetencesByUserId($_SESSION['user_data']['user_id'],$lId));
                        }
                        catch(Exception_MYSQL_Null_Rows $e){
                        }
                        try{
                            $this->_view->assign('allCompetences',$this->_model->getAllCompetences($lId));
                        }catch(Exception_MYSQL_Null_Rows $e){
                        }
                        
                        $question=infobox_Site_Model::model()->findInfoboxItemByKey('competenceDrawQuestionInfobox',$lId);
                        $this->_view->assign('question',$question);
                        
                        
                        $seo=seo_Site_Model::model()->getSeoItemByKey('competenceEdit',$lId);
                        Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/kompetencia/view/site.kompetencia_edit.tpl'));
                     
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        throw new Exception_404;
                }
        }
        
        public function onClick_Modify() {
            parent::onClick_Modify();
        }

        public function onClick_New() {
            //echo __METHOD__;
            //exit;
            parent::onClick_New();
        }
        
        public function onClick_DeleteComp() {
            $this->_model->deleteComp($_REQUEST['deleteCompId']);
        }
        
        public function onClick_AddComp() {
            $this->_model->addComp($_REQUEST['newCompId'],$_REQUEST['newCompValasz']);
        }
        
        public function onClick_EditComp() {
            $this->_model->editComp($_REQUEST['compId'],$_REQUEST['valasz']);
        }

}