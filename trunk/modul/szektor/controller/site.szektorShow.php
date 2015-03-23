<?php
/**
 * @property Kompetencia_Show_Model $_model
 * @property Smarty $_view
 */
require 'modul/seo/model/seo_Site_Model.php';
//require 'modul/infobox/model/infobox_Site_Model.php';
require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
class SzektorShow_Site_Controller extends Page_Edit
{
        
        public $_name='Szektor';
        
        public function __construct()
        {       
                $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                $this->__loadModel('_Show');
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
                        
                        $szektor = $this->_model->findSzektorByID($_GET['sid'],$lId);
                        $this->_view->assign('szektor',$szektor);
                        
                        $comments = $this->_model->findCommentsBySzektorID($szektor['szektor_id']);
                        $this->_view->assign('comments',$comments);
                        // Megtekintések számának növelése.
                        /*if($_COOKIE['szektor_megtekintes']!=$szektor['szektor_id'])
                        {
                                $this->_model->updateViews($szektor['szektor_id'],$lId);
                        }
                        setcookie('szektor_megtekintes', $szektor['szektor_id'],time()+300);
                        */
                        // Render
                        Rimo::$_site_frame->assign('PageName',$szektor['szektor_nev']);
                        
                        //Linkek
                        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        $links = ugyfellinkek_Site_Model::model()->findLinks('szektor',$szektor['szektor_id']);
                        
                        $this->_view->assign("linkMode","on");
                        $this->_view->assign("addLinkOption","on");
                        $this->_view->assign("links",$links);
                        
                        Rimo::$_site_frame->assign('site_title',$szektor['szektor_nev']);
                        Rimo::$_site_frame->assign('site_description',$szektor['szektor_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$szektor['szektor_meta_kulcsszo']);
                                                
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/szektor/view/site.szektor_show.tpl'));
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        throw new Exception_404;
                }
        }
        
        public function onClick_addComment() {
              
        try{
            $lId = Rimo::$_config->SITE_NYELV_ID;
            $szektor = $this->_model->findSzektorByID($_GET['sid'],$lId);
        
            if(!empty($_REQUEST['comment']))
            {
                $this->_model->addComment((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $szektor['szektor_id'],$_REQUEST['comment']);
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
        $szektor = $this->_model->findSzektorByID($_GET['sid'],$lId);
        
        ugyfellinkek_Site_Model::model()->validateSaveLink($clientId, $_REQUEST['linkName'], $_REQUEST['linkUrl'], 'szektor', $szektor['szektor_id']);
        ugyfellinkek_Site_Model::model()->saveLink($clientId, $_REQUEST['linkName'], $_REQUEST['linkUrl'], 'szektor', $szektor['szektor_id']);

    }
    
}