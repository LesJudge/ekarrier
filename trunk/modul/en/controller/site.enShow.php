 <?php
 require 'modul/seo/model/seo_Site_Model.php';
 require 'page/all/model/page.list_model.php';
 require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
class EnShow_Site_Controller extends Page_Edit
{

        public $_name="EnShow";

        public function __construct()
        {
            $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
            $this->__loadModel("_Show");
            parent::__construct();
            $this->__addParams($this->_model->_params);
            $this->__addEvent('BtnAddLink', 'addLink');
            $this->__addEvent('BtnDeleteLink', 'deleteLink');
            $this->__run();
              
        }

        public function __show()
        {
                parent::__show();
                try
                {        
                        $lId = Rimo::$_config->SITE_NYELV_ID;
                        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        
                        //Kompetenciák
                        $myComps = $this->_model->findCompetencesByClientId($clientId,$lId);
                        $this->_view->assign('myComps',$myComps);
                        
                        //Kompetenciarajzok
                        $myCompDraws = $this->_model->getAllCompRajzByClientId($clientId,$lId);
                        $this->_view->assign('myCompDraws',$myCompDraws);
                        
                        //Tevékenységi körök
                        $myTevkorok = $this->_model->getTevkorokByClientId($clientId);
                        $this->_view->assign('myTevkorok',$myTevkorok);
                        
                        
                        
                        
                        if(!isset($_SESSION['userstat']['ujAllashirdetes']))
                        {
                            $obj = $this->_model->getStat($clientId);
                            $prevStat = unserialize($obj[0]);
                        
                            if(is_array($prevStat) && !empty($prevStat))
                            {
                                $_SESSION['userstat']['ujAllashirdetes'] = $prevStat;
                                $this->_view->assign('prevStat',$prevStat);
                            }
                        }else{
                            $prevStat = $_SESSION['userstat']['ujAllashirdetes'];
                            $this->_view->assign('prevStat',$prevStat);
                        }
                        
                        foreach ($myTevkorok as $key=>$value)
                        {
                            $IDarr[] = $value['ID'];
                        }
                        
                        $tevkorStats = $this->_model->getNumberOfJobsOfTevkor($IDarr);

                        foreach ($tevkorStats as $key=>$value)
                        {
                            $STATarr[$value['ID']] = $value['ahDB'];
                        }
                        
                        
                        $this->_model->saveStat($clientId,serialize($STATarr));
                        
                        //if(!isset($_SESSION['userstat']['ujAllashirdetes']))
                        //{
                        
                        
                            
                        //}
                        
                        
                        
                        
                        
                        $this->_view->assign('tevkorStats',$tevkorStats);
                        
                        //Megjelölt álláshirdetések
                        $myMarkedJobs=$this->_model->getMarkedJobsByClientId($clientId);
                        $this->_view->assign('myMarkedJobs',$myMarkedJobs);
                        
                        //Kedvenc álláshirdetések
                        $myFavouriteJobs=$this->_model->getFavouriteJobsByClientId($clientId);
                        $this->_view->assign('myFavouriteJobs',$myFavouriteJobs);
                        
                        //Szektorteszt eredmények
                        $mySectorTestResult=$this->_model->getSectorTestResultByClientId($clientId);
                        $this->_view->assign('mySectorTestResult',$mySectorTestResult);
                        
                        // komprajzonkénti cégmegtekintés
                        $compRajzViews = $this->_model->getCompRajzViews($clientId);
                        $this->_view->assign('compRajzViews',$compRajzViews);
                        
                        
                        $this->_view->assign('compRajzViewsAll',  $this->_model->_totalCompRajzViews);
                        
                        
                        //Linkek
                        $links = ugyfellinkek_Site_Model::model()->findLinks($clientId);  
                        
                        $this->_view->assign("linkMode","on");
                        $this->_view->assign("addLinkOption","on");
                        $this->_view->assign("links",$links);
                        
                        
                        
                        //SEO
                        $seo = seo_Site_Model::model()->getSeoItemByKey('profil_en',$lId);
                        Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/en/view/site.en_show.tpl'));
                }
                catch(Exception_MYSQL $e)
                {
                        throw new Exception_404();
                }
        }
        
    public function onClick_addLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        ugyfellinkek_Site_Model::model()->validateSaveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."en/");
        ugyfellinkek_Site_Model::model()->saveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."en/");
    }
    
    public function onClick_deleteLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        ugyfellinkek_Site_Model::model()->validateDeleteLink($clientId, $_REQUEST['delLink']);
        ugyfellinkek_Site_Model::model()->deleteLink($clientId, $_REQUEST['delLink']);
    }
        
        
        
}

?>