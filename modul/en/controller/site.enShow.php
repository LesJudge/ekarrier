 <?php
 require 'modul/seo/model/seo_Site_Model.php';
 require 'page/all/model/page.list_model.php';
class EnShow_Site_Controller extends RimoController
{

        public $_name="EnShow";

        public function __construct()
        {
            $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
            $this->__loadModel("_Show");
            $this->__run();
              
        }

        public function __show()
        {
                parent::__show();
                try
                {        
                        $lId=Rimo::$_config->SITE_NYELV_ID;
                        $userId=UserLoginOut_Site_Controller::$_id;
                        $myComps=Rimo::__loadPublic('model','kompetencia_SiteEdit','kompetencia');
                        //var_dump($myComps->findCompetencesByUserId($userId,$lId));
                        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        $myMunkakorok=$this->_model->getMunkakorokById($clientId);
                        
                        $myMegjeloltek=$this->_model->getMegjeloltekById($clientId);
                        
                        
                        $this->_view->assign('myComps',$myComps->findCompetencesByUserId($userId,$lId));
                        $this->_view->assign('myMunkakorok',$myMunkakorok);
                        $this->_view->assign('myMegjeloltek',$myMegjeloltek);
                        $seo=seo_Site_Model::model()->getSeoItemByKey('profil_en',$lId);
                        Rimo::$_site_frame->assign('PageName',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                        Rimo::$_site_frame->assign("Content", $this->_view->fetch("modul/en/view/site.en_show.tpl"));
                }
                catch(Exception_MYSQL $e)
                {
                        throw new Exception_404();
                }
        }
        
       
}

?>