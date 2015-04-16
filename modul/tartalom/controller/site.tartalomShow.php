 <?php
class TartalomShow_Site_Controller extends RimoController
{

        public $_name="TartalomShow";

        public function __construct()
        {
            $this->__loadModel("_Show");
            $this->__run();
              
        }

        public function __show()
        {
                parent::__show();
                try
                {        
                      if(($_SESSION['type']=='ma' && empty($_REQUEST["link"])) OR $_REQUEST["link"]=='nyito-oldal'){
                            $_REQUEST["link"]='nyito-oldal';
                            Rimo::$_config->MASTER_TPL="page/all/view/page.ma.start.tpl";
                        }
                      
                        $data = $this->_model->getTartalom($_REQUEST["link"]);
                          
                       // if(!$_REQUEST["link"]OR$data[0]["tartalom_kezdolap"]==1)
                        if(!$_REQUEST["link"])
                        {
                            $data = $this->_model->getTartalomByID(20);
                            Rimo::$_site_frame->assign("text",$data[0]["tartalom_tartalom"]);
                            Rimo::$_config->MASTER_TPL="page/all/view/page.start.tpl";
                        }

                        Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>$data[0]["tartalom_cim"])));
                        Rimo::$_site_frame->assign("PageName", $data[0]["tartalom_cim"]);
                        UserLoginOut_Controller::verifyJogcsoportAccess($data[0]["jogcsoport_id"]);
                        if(!isset($_COOKIE['tartalom_megtekintes']) || $_COOKIE["tartalom_megtekintes"]!=$data[0]["tartalom_id"])
                        {
                                $this->_model->updateMegtekintes($data[0]["tartalom_id"]);
                        }
                        setcookie("tartalom_megtekintes", $data[0]["tartalom_id"], time()+300);

                        $this->_view->assign("data", $data);
                        $this->_view->assign("kapcsolodo", $this->_model->getKapcsolodo($data[0]["tartalom_id"]));
                        Rimo::$_site_frame->assign("site_title", $data[0]["tartalom_cim"]);
                        Rimo::$_site_frame->assign("site_description", $data[0]["tartalom_leiras"]);
                        Rimo::$_site_frame->assign("site_keywords", $data[0]["tartalom_meta_kulcsszo"]);

                        Rimo::$_site_frame->assign("Content", $this->_view->fetch("modul/tartalom/view/site.tartalom_show.tpl"));
                }
                catch(Exception_MYSQL $e)
                {
                        throw new Exception_404();
                }
        }
        
       
}

?>