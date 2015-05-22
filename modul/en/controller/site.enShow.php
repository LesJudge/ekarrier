 <?php
 require 'modul/seo/model/seo_Site_Model.php';
 //require 'page/all/model/page.list_model.php';
 //require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
class EnShow_Site_Controller extends Page_Edit
{
        public $_name="EnShow";

        public function __construct()
        {
            $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
            $this->__loadModel("_Show");
            parent::__construct();
            $this->__addParams($this->_model->_params);
            $this->__run();
        }

        public function __show()
        {
                parent::__show();
                try
                {        
                        $lId = Rimo::$_config->SITE_NYELV_ID;
                        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        
                        $tartalom = Rimo::__loadPublic('model', 'tartalom_Show', 'tartalom');
                        $obj = $tartalom->getTartalomByID(42);
                        $this->_view->assign("text1",$obj[0]["tartalom_tartalom"]);
   
                        // Új üzenetek
                        $newMessage = $this->_model->checkNewMessages($clientId);
                        $this->_view->assign('newMessage',$newMessage);
                        
                        //Kompetenciák
                        $myComps = $this->_model->findCompetencesByClientId($clientId,$lId);
                        $this->_view->assign('myComps',$myComps);
                        
                        //Kompetenciarajzok
                        $myCompDraws = $this->_model->getAllCompRajzByClientId($clientId,$lId);
                        $this->_view->assign('myCompDraws',$myCompDraws);
                        
                        //Tevékenységi körök
                        $myTevkorok = $this->_model->getTevkorokByClientId($clientId);
                        $this->_view->assign('myTevkorok',$myTevkorok);
                        
                        
                        foreach ($myTevkorok as $key=>$value)
                        {
                            $IDarr[] = $value['ID'];
                        }
                        
                        $tevkorStats = $this->_model->getNumberOfJobsOfTevkor($IDarr,$clientId);
                        $this->_view->assign('tevkorStats',$tevkorStats);
                        
                        //Megjelölt álláshirdetések
                        $myMarkedJobs=$this->_model->getMarkedJobsByClientId($clientId);
                        $this->_view->assign('myMarkedJobs',$myMarkedJobs);
                        
                        //Kedvenc álláshirdetések
                        $myFavouriteJobs=$this->_model->getFavouriteJobsByClientId($clientId);
                        $this->_view->assign('myFavouriteJobs',$myFavouriteJobs);
                        
                        //Szektorteszt eredmény
                        $mySectorTestResult=$this->_model->getSectorTestResultByClientId($clientId);
                        $this->_view->assign('mySectorTestResult',$mySectorTestResult);
                        
                        //Pozídióteszt eredmény
                        $myPositionTestResult = $this->_model->getPositionTestResultByClientId($clientId);
                        $this->_view->assign('myPositionTestResult',$myPositionTestResult);
                        
                        // komprajzonkénti cégmegtekintés
                        $compRajzViews = $this->_model->getCompRajzViews($clientId);
                        $this->_view->assign('compRajzViews',$compRajzViews);
                        $this->_view->assign('compRajzViewsAll',  $this->_model->_totalCompRajzViews);
                        
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
        
}

?>