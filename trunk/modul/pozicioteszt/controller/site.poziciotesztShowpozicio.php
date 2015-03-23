<?php
/**
 * @property Kompetencia_Show_Model $_model
 * @property Smarty $_view
 */
require 'modul/seo/model/seo_Site_Model.php';
//require 'modul/infobox/model/infobox_Site_Model.php';
require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';

class PoziciotesztShowpozicio_Site_Controller extends Page_Edit
{
        
        public $_name='PoziciotesztShowpozicio';
        
        public function __construct()
        {       
                $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                $this->__loadModel('_Pozicio_Show');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addEvent('BtnAddComment', 'addComment');
                $this->__addEvent('BtnAddLink', 'addLink');
                $this->__run();
        }
        
        public function __show()
        {
                try
                {
                        $lId = Rimo::$_config->SITE_NYELV_ID;
                        
                        $pozicio = $this->_model->findPozicioByLink($_GET['link']);
                        $this->_view->assign('pozicio',$pozicio);
                        
                        $comments = $this->_model->findCommentsByPozicioID($pozicio['pozicio_id']);
                        $this->_view->assign('comments',$comments);
                        // Render
                        Rimo::$_site_frame->assign('PageName',$pozicio['pozicio_nev']);
                        
                        //Linkek
                        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        $links = ugyfellinkek_Site_Model::model()->findLinks('pozicio',$pozicio['pozicio_id']);
                        
                        $this->_view->assign("linkMode","on");
                        $this->_view->assign("addLinkOption","on");
                        $this->_view->assign("links",$links);
                        
                        Rimo::$_site_frame->assign('site_title',$pozicio['pozicio_nev']);
                        Rimo::$_site_frame->assign('site_description','');
                        Rimo::$_site_frame->assign('site_keywords','');
                                                
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/pozicioteszt/view/site.pozicio_show.tpl'));
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        throw new Exception_404;
                }
        }
        
        public function onClick_addComment() {
              
        try{
            $lId = Rimo::$_config->SITE_NYELV_ID;
            $pozicio = $this->_model->findPozicioByLink($_GET['link']);
        
            if(!empty($_REQUEST['comment']))
            {
                $this->_model->addComment((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $pozicio['pozicio_id'],$_REQUEST['comment']);
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
        $lId=Rimo::$_config->SITE_NYELV_ID;
        $pozicio = $this->_model->findPozicioByLink($_GET['link']);
        
        ugyfellinkek_Site_Model::model()->validateSaveLink($clientId, $_REQUEST['linkName'], $_REQUEST['linkUrl'], 'pozicio', $pozicio['pozicio_id']);
        ugyfellinkek_Site_Model::model()->saveLink($clientId, $_REQUEST['linkName'], $_REQUEST['linkUrl'], 'pozicio', $pozicio['pozicio_id']);

    }
    
}