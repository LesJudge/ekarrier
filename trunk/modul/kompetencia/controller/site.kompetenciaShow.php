<?php
/**
 * @property Kompetencia_Show_Model $_model
 * @property Smarty $_view
 */
require 'modul/seo/model/seo_Site_Model.php';
require 'modul/infobox/model/infobox_Site_Model.php';
require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
class KompetenciaShow_Site_Controller extends Page_Edit
{
        
        public $_name='Kompetencia';
        
        public function __construct()
        {       
                $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                $this->__loadModel('_Show');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addEvent('BtnAddComment', 'addComment');
                $this->__addEvent('BtnAddLink', 'addLink');
                $this->__addEvent('BtnDeleteLink', 'deleteLink');
                $this->__run();
        }
        
        public function __show()
        {
                try
                {
                        $lId=Rimo::$_config->SITE_NYELV_ID;
                        
                        if($_REQUEST['link']!='tesztek'){
                        // Kompetencia adatainak lekérdezése.
                        $competence=$this->_model->findCompetenceByUrl($_GET['link'],$lId);
                        $this->_view->assign('competence',$competence);
                        
                        $comments = $this->_model->findCommentsByCompetenceID($competence['kompetencia_id']);
                        $this->_view->assign('comments',$comments);
                        // Megtekintések számának növelése.
                        if($_COOKIE['kompetencia_megtekintes']!=$competence['kompetencia_id'])
                        {
                                $this->_model->updateViews($competence['kompetencia_id'],$lId);
                        }
                        setcookie('kompetencia_megtekintes', $competence['kompetencia_id'],time()+300);
                        // Render
                        Rimo::$_site_frame->assign('PageName',$competence['kompetencia_nev']);
                        Rimo::$_site_frame->assign('Indikator',array(
                                1=>array(
                                        'nev'=>'Kompetenciák',
                                        'link'=>Rimo::$_config->DOMAIN.'kompetenciak/'
                                ),
                                2=>array(
                                        'nev'=>$competence['kompetencia_nev'],
                                )
                        ));
                        
                        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        $links = ugyfellinkek_Site_Model::model()->findLinks($clientId);
                        
                        
                        $this->_view->assign("linkMode","on");
                        $this->_view->assign("addLinkOption","on");
                        $this->_view->assign("links",$links);
                        
                        Rimo::$_site_frame->assign('site_title','Munkáltatók - '.$competence['kompetencia_nev']);
                        Rimo::$_site_frame->assign('site_description',$competence['kompetencia_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$competence['kompetencia_meta_kulcsszo']);
                                                
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/kompetencia/view/site.kompetencia_show.tpl'));
                        }else{
                            
                            $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                            $links = ugyfellinkek_Site_Model::model()->findLinks($clientId);
                        
                        
                            $this->_view->assign("linkMode","on");
                            $this->_view->assign("addLinkOption","on");
                            $this->_view->assign("links",$links);
                            
                            $topinfo=infobox_Site_Model::model()->findInfoboxItemByKey('competencesTestsTopInfobox',$lId);
                            $this->_view->assign('topinfo',$topinfo);
                            
                            $leftinfo=infobox_Site_Model::model()->findInfoboxItemByKey('competencesTestsLeftInfobox',$lId);
                            $this->_view->assign('leftinfo',$leftinfo);
                            
                            $rightinfo=infobox_Site_Model::model()->findInfoboxItemByKey('competencesTestsRightInfobox',$lId);
                            $this->_view->assign('rightinfo',$rightinfo);
                            
                            $seo=seo_Site_Model::model()->getSeoItemByKey('testselect',$lId);
                            Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                            Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                            Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                            Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                            Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/kompetencia/view/site.kompetencia_show_utmutato.tpl'));
                        }
                        
                
                        
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        throw new Exception_404;
                }
        }
        
        
        public function onClick_addComment() {
              
        try{
            $lId = Rimo::$_config->SITE_NYELV_ID;
            $competence = $this->_model->findCompetenceByUrl($_GET['link'],$lId);
        
            if(!empty($_REQUEST['comment']))
            {
                $this->_model->addComment((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $competence['kompetencia_id'],$_REQUEST['comment']);
                throw new Exception_Form_Message('Üzenet elküldve!');
            }
            else
            {
                throw new Exception_Form_Error("Írjon be szöveget!");
            }
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        
    }
    
    public function onClick_addLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        if($_REQUEST['link']!='tesztek'){
            ugyfellinkek_Site_Model::model()->validateSaveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."kompetenciak/".$_GET['link']);
        }
        else{
            ugyfellinkek_Site_Model::model()->validateSaveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."kompetenciak/tesztek");
        }
        ugyfellinkek_Site_Model::model()->saveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."kompetenciak/".$_GET['link']);

    }
    
    public function onClick_deleteLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        ugyfellinkek_Site_Model::model()->validateDeleteLink($clientId, $_REQUEST['delLink']);
        ugyfellinkek_Site_Model::model()->deleteLink($clientId, $_REQUEST['delLink']);
    }
}