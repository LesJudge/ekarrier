 <?php
 require 'modul/seo/model/seo_Site_Model.php';
 //require 'page/all/model/page.list_model.php';
 //require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
class EncegShow_Site_Controller extends Page_Edit
{
        public $_name="EncegShow";

        public function __construct()
        {
            $companyId = (int)Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
            $this->__loadModel("_Show");
            parent::__construct();
            $this->__addParams($this->_model->_params);
            $this->__addEvent('BtnCreateFolder', 'createFolder');
            $this->__addEvent('BtnUploadPic', 'uploadPic');
            $this->__addEvent('BtnUpdateDescription', 'updateDescription');
            
            $this->__run();
        }

        public function __show()
        {
                parent::__show();
                try
                {        
                        $lId = Rimo::$_config->SITE_NYELV_ID;
                        $companyId = (int)Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        
                        // Álláshirdetések
                        $myJobs = $this->_model->getJobsByCompanyId($companyId);
                        
                        $this->_view->assign('myJobs',$myJobs);
                        
                        $myFolders = $this->_model->getFoldersByCompanyId($companyId);
                        $this->_view->assign('myFolders',$myFolders);
                        
                        $companyData = $this->_model->getCompanyData($companyId);
                        
                        $companyCreateDate = $this->_model->getCompanyCreateDate($companyId);
                        $this->_view->assign('companyCreateDate',$companyCreateDate['letrehozas_datum']);
                        
                        $startDate = $companyCreateDate['letrehozas_datum'];
                        $endDate =  date("Y-m-d");
                        
                        if($this->_model->checkDates($_REQUEST['startDate'],$_REQUEST['endDate']) === true){
                            $startDate = $_REQUEST['startDate'];
                            $endDate = $_REQUEST['endDate'];
                        }
                            $this->_view->assign('startDate',$startDate);
                            $this->_view->assign('endDate',$endDate);
                            
                            $stat = $this->_model->getStat($companyId,$startDate,$endDate);
                            $this->_view->assign('stat',$stat);
                            
                            $activeClientsSum = $this->_model->getActiveClientsSum();
                            $this->_view->assign('activeClientsSum',$activeClientsSum);
                        
                        
                        $this->_view->assign('companyData',$companyData);
                        
                        
                        //SEO
                        $seo = seo_Site_Model::model()->getSeoItemByKey('profil_ceg_en',$lId);
                        Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/enceg/view/site.enceg_show.tpl'));
                }
                catch(Exception_MYSQL $e)
                {
                        throw new Exception_404();
                }
        }
        
        public function onClick_createFolder() {
        $companyID = Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $folder = Rimo::__loadPublic('model','kompetenciarajzkereso_Site_List','kompetenciarajzkereso');
        try{
            if(!empty($_REQUEST['folderName']) && strlen($_REQUEST['folderName']) >= 5)
            {
                
                if($folder->checkIfFolderExistsByName($companyID,$_REQUEST['folderName']) === false)
                {
                    $folder->createFolder((int)$companyID, $_REQUEST['folderName']);
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
    
    public function onClick_uploadPic() {
        $companyID = Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        try{
            $this->_model->uploadPic($companyID);
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }  
    }
    
    public function onClick_updateDescription() {
        $companyID = Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        try{
            $this->_model->updateDescription($_REQUEST['companyDescription'],$companyID);
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }  
    }
        
}

?>