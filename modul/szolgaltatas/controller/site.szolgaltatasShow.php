 <?php
 require 'modul/seo/model/seo_Site_Model.php';
 //require 'page/all/model/page.list_model.php';
 //require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
class SzolgaltatasShow_Site_Controller extends Page_Edit
{

        public $_name="SzolgaltatasShow";
        private $visitType;

        public function __construct()
        {
            $this->init();
            $this->__loadModel("_Show");
            parent::__construct();
            $this->__addParams($this->_model->_params);
            if($this->visitType == 'company'){
                $this->__addEvent('BtnOrderService', 'orderService');
            }
            if($this->visitType == 'client'){
                $this->__addEvent('BtnOrderClientService', 'orderClientService');
            }
            $this->__run();
              
        }

        public function __show()
        {
                parent::__show();
                try
                {        
                        $tartalom = Rimo::__loadPublic('model', 'tartalom_Show', 'tartalom');
                        if($this->visitType == 'company'){
                            $services = $this->_model->getSzolgaltatasok('company');
                            $this->_view->assign('services', $services);
                            
                            $companyID = Rimo::getCompanyWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id);
                            $folders = $this->_model->getFolders($companyID);
                            $pendingOrders = $this->_model->getPendingOrders($companyID,'company');
                            
                            $myJobsModel = Rimo::__loadPublic('model', 'enceg_Show', 'enceg');
                            $myJobs = $myJobsModel->getJobsByCompanyId($companyID);
                            $this->_view->assign('myJobs',$myJobs);
                            
                            $this->_view->assign("folders", $folders);
                            $this->_view->assign("pendingOrders", $pendingOrders);
                            $this->_view->assign("loggedInAs", "company");
                            $this->_view->assign("loggedIn", "1");
                            
                            $obj = $tartalom->getTartalomByID(38);
                            $this->_view->assign("textCompany",$obj[0]["tartalom_tartalom"]);
                        }
                        
                        if($this->visitType == 'client'){
                            
                            $services = $this->_model->getSzolgaltatasok('client');
                            $clientID = Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id);
                            $pendingOrders = $this->_model->getPendingOrders($clientID,'client');
                            $this->_view->assign("pendingOrders", $pendingOrders);
                            $this->_view->assign('services', $services);
                            $this->_view->assign("loggedInAs", "client");
                            $this->_view->assign("loggedIn", "1");
                            $obj = $tartalom->getTartalomByID(37);
                            $this->_view->assign("textClient",$obj[0]["tartalom_tartalom"]);
                        }
                        
                        if($this->visitType == 'neutral'){
                            if($_SESSION['type']=='ma'){
                                $services = $this->_model->getSzolgaltatasok('company');
                                $obj = $tartalom->getTartalomByID(38);
                                $this->_view->assign("textCompany",$obj[0]["tartalom_tartalom"]);
                                $this->_view->assign('regLink', 'ceg/regisztracio/');
                            }
                            if($_SESSION['type']=='mv'){
                                $obj = $tartalom->getTartalomByID(37);
                                $this->_view->assign("textClient",$obj[0]["tartalom_tartalom"]);
                                $services = $this->_model->getSzolgaltatasok('client');
                                $this->_view->assign('regLink', 'munkavallalo/regisztracio/');
                            }
                            $this->_view->assign('services', $services);
                            $this->_view->assign("loggedIn", "0");
                        }
                        
                        
                        
                        //SEO
                        $seo = seo_Site_Model::model()->getSeoItemByKey('profil_en',$lId);
                        Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/szolgaltatas/view/site.szolgaltatas_show.tpl'));
                }
                catch(Exception_MYSQL $e)
                {
                        throw new Exception_404();
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
        
    public function onClick_orderService(){
        $companyID = Rimo::getCompanyWebUser()->verify(UserLoginOut_Controller::$_id);
        try{
            if(!isset($_REQUEST['serviceID']) || (int)$_REQUEST['serviceID'] < 1){
                throw new Exception_Form_Error("Hiba történt!");
            }
            if($this->_model->pendingOrderExists($companyID, $_REQUEST['serviceID'],'company')){
                throw new Exception_Form_Message('Megrendelése feldolgozás alatt!');
            }
            
            //$this->_model->saveOrder($companyID, $_REQUEST['serviceID'] ,$_REQUEST['folders']);
            $this->_model->saveOrder($companyID, $_REQUEST['serviceID'], $_REQUEST["".$_REQUEST['serviceID']."clients"], $_REQUEST["".$_REQUEST['serviceID']."clientsMarkers"]);
            throw new Exception_Form_Message('Sikeres megrendelés!');
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
    }
    
    public function onClick_orderClientService(){
        $clientID = Rimo::getClientWebUser()->verify(UserLoginOut_Controller::$_id);
        try{
            if(!isset($_REQUEST['clientServiceID']) || (int)$_REQUEST['clientServiceID'] < 1){
                throw new Exception_Form_Error("Hiba történt!");
            }
            if($this->_model->pendingOrderExists($clientID, $_REQUEST['serviceID'],'client')){
                throw new Exception_Form_Message('Megrendelése feldolgozás alatt!');
            }
            $this->_model->saveClientOrder($clientID, $_REQUEST['clientServiceID']);
            throw new Exception_Form_Message('Sikeres megrendelés!');
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
    }
}

?>