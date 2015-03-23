<?php
require 'modul/seo/model/seo_Site_Model.php';
//require 'modul/infobox/model/infobox_Site_Model.php';

class KompetenciarajzkeresoList_Site_Controller extends Admin_List
{
    public $_name = 'SiteKompetenciarajzkeresoList';
    protected $_multiple_lang = false;
    private $visitType;
    
    public function __construct()
    {   
        $this->init(); 
        $this->__loadModel('_Site_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addEvent('BtnAddDraws', 'addDraws');
        $this->__addEvent('BtnCreateFolder', 'createFolder');
        $this->__run();
    }
    
    public function __show()
    {
       
        parent::__show();
        
        $lId = Rimo::$_config->SITE_NYELV_ID;
        
        if( isset($_GET['oldal'])   || $this->getItemValue('FilterCsoport') > -1 
                                    || $this->getItemValue('FilterKor') > -1
                                    || $this->getItemValue('FilterSzektor') > 0
                                    || $this->getItemValue('FilterPozicio') > 0
                                    || $this->getItemValue('FilterMunkakor') > 0)
        {
            $this->_view->assign("jumpToAnc","1");
        }
        
        if($this->visitType =='company'){
            $companyID = (int)Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
            $folders = $this->_model->getFolders($companyID);
            
            $this->_view->assign("folders",$folders);
            $this->_view->assign("loggedInAs","company");
        }
        
        //SEO
        $seo = seo_Site_Model::model()->getSeoItemByKey('kompetenciarajzkereso',$lId);
        
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('Indikator', array());
        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/kompetenciarajzkereso/view/site.kompetenciarajzkereso_list.tpl'));
    }
    
    public function onClick_Filter()
    {
        $filterMunkakor = $this->getItemValue('FilterMunkakor');
        if (!empty($filterMunkakor)) {
            $this->setWhereInput("m.munkakor_nev LIKE '%" . mysql_real_escape_string($filterMunkakor) . "%' OR a.megnevezes LIKE '%" . mysql_real_escape_string($filterMunkakor) . "%'", 'FilterMunkakor');
        } else {
            unset($_SESSION[$this->_name]['FilterMunkakor']);
        }
        
        //Főkat szűrő
        $filterCsoport = $this->getItemValue('FilterCsoport');  
        if(is_null($filterCsoport) || $filterCsoport == '-1')
        {
            unset($_SESSION[$this->_name]['FilterCsoport']);
        }
        else
        {
            $this->setWhereInput(' (SELECT
                                mk3.munkakor_kategoria_id 
                                FROM munkakor_kategoria mk3
                                WHERE mk3.baloldal < mk.baloldal AND mk3.jobboldal > mk.jobboldal AND mk3.munkakor_kategoria_aktiv = 1 AND mk3.munkakor_kategoria_torolt = 0 AND mk3.szint = 1) = '.(int)$filterCsoport, 'FilterCsoport');
        } 
        
        //Alkat szűrő
        $filterKor = $this->getItemValue('FilterKor');
          
        if(is_null($filterKor) || $filterKor == '-1')
        {
            unset($_SESSION[$this->_name]['FilterKor']);
        }
        else
        {
            $this->setWhereInput('mk.munkakor_kategoria_id = '.(int)$filterKor, 'FilterKor');
        }
        
        //Szektor szűrő
        $filterSzektor = $this->getItemValue('FilterSzektor');
          
        if(is_null($filterSzektor) || $filterSzektor == '')
        {
            unset($_SESSION[$this->_name]['FilterSzektor']);
        }
        else
        {
            $this->setWhereInput('a.szektor_id = '.(int)$filterSzektor, 'FilterSzektor');
        }
        
        //Poz szűrő
        $filterPozicio = $this->getItemValue('FilterPozicio');
          
             if(is_null($filterPozicio) || $filterPozicio == '')
        {
            unset($_SESSION[$this->_name]['FilterPozicio']);
        }
        else
        {
            $this->setWhereInput('a.pozicio_id = '.(int)$filterPozicio, 'FilterPozicio');
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
    
    public function onClick_addDraws() {
        $companyID = Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        
        try{
            if(!empty($_REQUEST['folders']) && (int)$_REQUEST['folders'] > 0)
            {
                if(isset($_REQUEST['draws']) && is_array($_REQUEST['draws']) && count($_REQUEST['draws']) > 0){
                    $this->_model->addDrawsToFolder($_REQUEST['folders'], $_REQUEST['draws']);
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