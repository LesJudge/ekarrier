<?php
/**
 * @property Kompetencia_Show_Model $_model
 * @property Smarty $_view
 */
require 'modul/seo/model/seo_Site_Model.php';
require 'modul/infobox/model/infobox_Site_Model.php';
require "modul/email/site.email.php";
require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';

class KompetenciaRajzEdit_Site_Controller extends Page_Edit
{
        
        public $_name='KompetenciaRajzEdit';
        
        public function __construct()
        {
           
                
                $this->__loadModel('_SiteRajzEdit');
                $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                $this->_model->setClientId($clientId);
                
                
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addEvent('BtnSaveCompRajz','SaveCompRajz');
                $this->__addEvent('BtnSaveAsCompRajz','SaveAsCompRajz');
                $this->__addEvent('BtnUpdateCompRajz','UpdateCompRajz');
                $this->__addEvent('BtnDeleteCompRajz','DeleteCompRajz');
                $this->__addEvent('BtnRequestExpertOpinion','RequestExpertOpinion');
                $this->__addEvent('BtnAddLink', 'addLink');
                $this->__addEvent('BtnDeleteLink', 'deleteLink');
                $this->__run();
        }
        
        public function __show()
        {
                try
                {
                       
                        $lId=Rimo::$_config->SITE_NYELV_ID;
                        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        
                        // -----  Létező Kompetenciarajz
                        $_REQUEST['krid'] = mysql_real_escape_string($_REQUEST['krid']);
                        
                        if(isset($_REQUEST['krid']) && (int)$_REQUEST['krid'] > 0)
                        {
                            try
                            {
                                $rajzID = $this->_model->getCompRajzById((int)$_REQUEST['krid']);
                                $this->_view->assign('compRajzID', $rajzID['kompetenciarajz_id']);
                                $this->_view->assign('compRajzNev', $rajzID['kompetenciarajz_nev']);
                                $this->_view->assign('mode','modify');
                            }
                            catch(Exception_MYSQL_Null_Rows $e)
                            {
                               throw new Exception_404;
                            }catch(Exception_MYSQL $e)
                            {
                                throw new Exception_404;
                            }
                             
                           
                            $this->_view->assign('compRajzCompetences',$this->_model->findCompetencesByCompRajzId($rajzID['kompetenciarajz_id']));
                            $opinions = $this->_model->getOpinionsByCompRajzID($rajzID['kompetenciarajz_id']);
                            $this->_view->assign('opinions',$opinions);
                           
                            
                        }else // -----  Új Kompetenciarajz
                        {
                            
                            
                            $this->_view->assign('compRajzCompetences',$this->_model->findCompetencesByClientId($clientId,$lId));
                            $this->_view->assign('mode','new');
                            
                            $links = ugyfellinkek_Site_Model::model()->findLinks($clientId);  
                            $this->_view->assign("linkMode","on");
                            $this->_view->assign("addLinkOption","on");
                            $this->_view->assign("links",$links);
                        }
                        
                        
                            $compRajzok = $this->_model->getAllCompRajz();
                            $this->_view->assign('compRajzok',$compRajzok);

                        
                        //$question = infobox_Site_Model::model()->findInfoboxItemByKey('competenceDrawQuestionInfobox',$lId);
                        //$this->_view->assign('question',$question);
                        
                        
                        
                        
                        $seo=seo_Site_Model::model()->getSeoItemByKey('competenceEdit',$lId);
                        Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/kompetencia/view/site.kompetenciarajz_edit.tpl'));
                     
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
            parent::onClick_New();
        }
        

        public function onClick_SaveCompRajz()
        {   
            try
            {
                if(count($_REQUEST['CompRajzKompetenciak']) < 1)
                {
                    throw new Exception_Form_Error("A kompetenciarajznak legalább egy kompetenciát tartalmaznia kell!");
                }
                
                $compRajzok = $this->_model->getAllCompRajz();
                if(count($compRajzok) >= '5')
                {
                    throw new Exception_Form_Error("Maximum 5 kompetenciarajzot készíthet!");
                }
                
                if(!$this->_model->validateComprajzNev($_REQUEST['CompRajzNev']))
                {
                    throw new Exception_Form_Error("Nem megfelelő név! (Min. 5 karakter)");
                }
                else
                {
                    $this->_model->saveCompRajz($_REQUEST['CompRajzNev'],$_REQUEST['CompRajzKompetenciak'],$_REQUEST['CompRajzValaszok']);
                    throw new Exception_Form_Message("Sikeres hozzáadás!");
                }   
            }
            catch(Exception_MYSQL $e)
            {
                throw new Exception_Form_Error("Hiba történt!");
            } 
        }
        
        public function onClick_SaveAsCompRajz()
        {
            if(count($_REQUEST['CompRajzKompetenciak']) < 1)
                {
                    throw new Exception_Form_Error("A kompetenciarajznak legalább egy kompetenciát tartalmaznia kell!");
                }
            try
            {
            
            $compRajzok = $this->_model->getAllCompRajz();
                if(count($compRajzok) >= '5')
                {
                    throw new Exception_Form_Error("Maximum 5 kompetenciarajzot készíthet!");
                }
                
            if($this->_model->checkIfCompRajzExistsByName($_REQUEST['CompRajzNev']))
            {
               throw new Exception_Form_Error("Már létezik ilyen nevű kompetenciarajz!");
            }
            else if(!$this->_model->validateComprajzNev($_REQUEST['CompRajzNev']))
            {
                throw new Exception_Form_Error("Nem megfelelő név! (Min. 5 karakter)");
            }
            else
            {
                $this->_model->saveCompRajz($_REQUEST['CompRajzNev'],$_REQUEST['CompRajzKompetenciak'],$_REQUEST['CompRajzValaszok']);
                throw new Exception_Form_Message("Sikeres hozzáadás!");
            }
            }
            catch(Exception_MYSQL $e)
            {
                throw new Exception_Form_Error("Hiba történt!");
            } 
            
        }
        
        public function onClick_UpdateCompRajz()
        {
            if(count($_REQUEST['CompRajzKompetenciak']) < 1)
                {
                    throw new Exception_Form_Error("A kompetenciarajznak legalább egy kompetenciát tartalmaznia kell!");
                }
            try
            {
                if($this->_model->validateComprajzNev($_REQUEST['CompRajzNev']))
                {
                    $this->_model->updateCompRajz($_REQUEST['CompRajzNev'],$_REQUEST['CompRajzKompetenciak'],$_REQUEST['CompRajzValaszok'],$_REQUEST['CompRajzID']);
                    throw new Exception_Form_Message("Sikeres módosítás!");
                }else
                {
                    throw new Exception_Form_Error("Nem megfelelő név! (Min. 5 karakter)");
                }
            }
            catch(Exception_MYSQL $e)
            {
                throw new Exception_Form_Error("Hiba történt!");
            } 
        }
        
        public function onClick_DeleteCompRajz()
        {
            try
            {
                $this->_model->deleteCompRajz($_REQUEST['CompRajzID']);
                header('Location: '.Rimo::$_config->DOMAIN.'kompetenciak/kompetenciarajz-keszites/');
            }
            catch(Exception_MYSQL $e)
            {
                throw new Exception_Form_Error("Hiba történt!");
            } 
        }
        
        public function onClick_RequestExpertOpinion()
        {
            try
            {
                if($this->_model->checkIfRequestExistsWithNoAnswer($_REQUEST['CompRajzID']))
                {
                   throw new Exception_Form_Message("Kérése már feldolgozás alatt van!");
                }
                else
                {
                    $this->_model->requestExpertOpinion($_REQUEST['CompRajzID']);
                    $this->sendEmail();
                }
            }
            catch(Exception_MYSQL $e)
            {
                throw new Exception_Form_Error("Hiba történt!");
            } 
        }
        
        private function sendEmail()
	{
		$mailer = new RimoMailerFromDB($this->_model->_DB);

		//$mailer->BodyTPL->assign("cegnev",$this->_params["TxtNev"]->_value);
		//$mailer->BodyTPL->assign("email",$this->_params["TxtEmail"]->_value);
		
		$mailer->emailFromDB(4);
		//$mailer->AddAddress($this->_params["TxtEmail"]->_value);
                $mailer->AddAddress("gazdag.gergo@uniweb.hu");
		
		$mailer->Send();
                throw new Exception_Form_Message("Kérését elküldtük!");

	}
        
        public function onClick_addLink() {
            $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
            ugyfellinkek_Site_Model::model()->validateSaveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."kompetenciak/kompetenciarajz-keszites/");
            ugyfellinkek_Site_Model::model()->saveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."kompetenciak/kompetenciarajz-keszites/");
        }
    
        public function onClick_deleteLink() {
            $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
            ugyfellinkek_Site_Model::model()->validateDeleteLink($clientId, $_REQUEST['delLink']);
            ugyfellinkek_Site_Model::model()->deleteLink($clientId, $_REQUEST['delLink']);
        }

}