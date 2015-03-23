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
            if($this->visitType == 'company')
                {
                    $this->__addEvent('BtnOrderService', 'orderService');
                }
            $this->__run();
              
        }

        public function __show()
        {
                parent::__show();
                try
                {        
                        $services = $this->_model->getSzolgaltatasok();
                        $this->_view->assign('services', $services);
                            
                        if($this->visitType == 'company'){
                            $companyID = Rimo::getCompanyWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id);
                            $folders = $this->_model->getFolders($companyID);
                            $pendingOrders = $this->_model->getPendingOrders($companyID);
                            
                            $this->_view->assign("folders", $folders);
                            $this->_view->assign("pendingOrders", $pendingOrders);
                            $this->_view->assign("loggedInAs", "company");
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
        
    public function onClick_orderService()
    {
        $companyID = Rimo::getCompanyWebUser()->verify(UserLoginOut_Controller::$_id);
        
        try{
            if(!isset($_REQUEST['serviceID']) || (int)$_REQUEST['serviceID'] < 1){
                throw new Exception_Form_Error("Hiba történt!");
            }
            if($this->_model->pendingOrderExists($companyID, $_REQUEST['serviceID'])){
                throw new Exception_Form_Message('Megrendelése feldolgozás alatt!');
            }
            
            $this->_model->saveOrder($companyID, $_REQUEST['serviceID'] ,$_REQUEST['folders']);
            throw new Exception_Form_Message('Sikeres megrendelés!');
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
    }
}

?>