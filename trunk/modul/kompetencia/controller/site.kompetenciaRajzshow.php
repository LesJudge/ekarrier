<?php
//require 'modul/infobox/model/infobox_Site_Model.php';
class KompetenciaRajzShow_Site_Controller extends Page_Edit
{
        public $_name='KompetenciaRajzShow';
        private $visitType;
        
        public function __construct()
        {
                $this->init();             
                $this->__loadModel('_SiteRajzShow');

                parent::__construct();
                $this->__addParams($this->_model->_params);
                if($this->visitType == 'company')
                {
                    $this->__addEvent('BtnAddDraw', 'addDraw');
                    $this->__addEvent('BtnCreateFolder', 'createFolder');
                }

                $this->__run();
        }
        
        public function __show()
        {
                try
                {
                        $lId=Rimo::$_config->SITE_NYELV_ID;
                        
                        
                        $_REQUEST['krid'] = mysql_real_escape_string($_REQUEST['krid']);
                        
                        // -----  ha ügyfél van bejelentkezve
                        if($this->visitType === "client")
                        {
                            $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                            $this->_model->setClientId($clientId);
                            
                            $forceForeign = 0;
                            if($_GET['forceforeign'] == '1')
                            {
                                $forceForeign = 1;
                            }
                            
                            try
                            {
                                $rajzID = $this->_model->getCompRajzById((int)$_REQUEST['krid'],"ceg");
                                // ha saját
                                if($clientId == $rajzID['uID'] && $forceForeign == 0)
                                {
                                    $this->_view->assign('compRajzAuthor', $rajzID['nev']);
                                    $this->_view->assign('compRajzTitle', $rajzID['kompetenciarajz_nev']);
                               // ha nem saját
                                }else
                                {
                                    $this->_view->assign('compRajzAuthor', $rajzID['uID']);
                                    $this->_view->assign('compRajzTitle', $rajzID['krID']);
                                }   
                            }
                            catch(Exception_MYSQL_Null_Rows $e)
                            {
                               throw new Exception_404;
                            }
                            //komprajz kompetenciái
                            try
                            {
                                $this->_view->assign('compRajzCompetences',$this->_model->findCompetencesByCompRajzId($rajzID['krID']));
                            }
                            catch(Exception_MYSQL_Null_Rows $e)
                            {
                            }
                        }
                        // ha cég van bejelntkezve
                        if($this->visitType === "company")
                        {
                            try
                            {
                                $rajzID = $this->_model->getCompRajzById((int)$_REQUEST['krid'],"ceg");
                                $companyID = Rimo::getCompanyWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id);
                                $this->_model->addCompanyToViewed($rajzID['krID'],$companyID);
                                $this->_view->assign('compRajzAuthor', $rajzID['uID']);
                                $this->_view->assign('compRajzTitle', $rajzID['krID']);
                                
                                
                                $folders = $this->_model->getFolders($companyID);
                                $this->_view->assign("folders",$folders);
                                $this->_view->assign("loggedInAs","company");
                            }
                            catch(Exception_MYSQL_Null_Rows $e)
                            {
                               throw new Exception_404;
                            }
                            try
                            {
                           //komprajz kompetenciái
                                $this->_view->assign('compRajzCompetences',$this->_model->findCompetencesByCompRajzId($rajzID['krID']));
                            }
                            catch(Exception_MYSQL_Null_Rows $e)
                            {
                            }
                        }
                        
                        if($this->visitType === "neutral")
                        {
                            try
                            {
                                $rajzID = $this->_model->getCompRajzById((int)$_REQUEST['krid'],"ceg");
                                $this->_view->assign('compRajzAuthor', $rajzID['uID']);
                                $this->_view->assign('compRajzTitle', $rajzID['krID']);
                                
                            }
                            catch(Exception_MYSQL_Null_Rows $e)
                            {
                               throw new Exception_404;
                            }
                            try
                            {
                           //komprajz kompetenciái
                                $this->_view->assign('compRajzCompetences',$this->_model->findCompetencesByCompRajzId($rajzID['krID']));
                            }
                            catch(Exception_MYSQL_Null_Rows $e)
                            {
                            }
                        }
              
                        Rimo::$_site_frame->assign('PageName','Kompetenciarajz megtekintése');
                        Rimo::$_site_frame->assign('site_title','Kompetenciarajz megtekintése');
                        Rimo::$_site_frame->assign('site_description','');
                        Rimo::$_site_frame->assign('site_keywords','');
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/kompetencia/view/site.kompetenciarajz_show.tpl'));
                     
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        throw new Exception_404;
                }
        }
        
    protected function isLoggedIn()
    {
        return (int)UserLoginOut_Site_Controller::$_id > 0;
    }
  
    protected function init()
    {
        if ($this->isLoggedIn()) {
            try{
                $clientID = Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id);
             }catch(Exception_MYSQL_Null_Rows $e){
            }
            
            try{
                $companyID = Rimo::getCompanyWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id);
             }catch(Exception_MYSQL_Null_Rows $e){
            }
        
            if (empty($clientID) && empty($companyID))
            {
                throw new Exception_404();
                return false;
            }
            // ha cég van bejelentkezve
            if (empty($clientID) && (int)$companyID > 0)
            {
                $this->visitType = "company";
                return true;
            }
            
            // ha ügyfél van bejelentkezve
            if (empty($companyID) && (int)$clientID > 0)
            {
                $this->visitType = "client";
                return true;
            }
            
        }else{
            $this->visitType = "neutral";
        }
    }
    
    public function onClick_addDraw() {
        
        $companyID = Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $rajzID = $this->_model->getCompRajzById((int)$_REQUEST['krid'],'ceg');
        
        try{
            
            if(!empty($_REQUEST['folders']) && (int)$_REQUEST['folders'] > 0)
            {
                if((int)$rajzID['krID'] > 0){
                    $this->_model->addDrawToFolder($_REQUEST['folders'], $rajzID['krID']);
                    throw new Exception_Form_Message('Sikeresen hozzáadva!');
                }else
                {
                    throw new Exception_Form_Error("Válasszon legalább 1 kompetenciarajzot!");
                }
            }
            else
            {
                throw new Exception_Form_Error("Válasszon mappát!");
            }
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }  
    }
    
    public function onClick_createFolder() {
        $companyID = Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        
        try{
            if(!empty($_REQUEST['folderName']) && strlen($_REQUEST['folderName']) >= 5)
            {
                
                if($this->_model->checkIfFolderExistsByName($companyID,$_REQUEST['folderName']) === false)
                {
                    $this->_model->createFolder((int)$companyID, $_REQUEST['folderName']);
                    throw new Exception_Form_Message('Mappa létrehozva!');
                }else
                {
                    throw new Exception_Form_Error("Már létezik ilyen nevű mappa!");
                }
            }
            else
            {
                throw new Exception_Form_Error("Nem megfelelő név! (Min. 5 karakter)");
            }
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }  
    }
}