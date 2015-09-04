<?php
/**
 * @property Kompetencia_Show_Model $_model
 * @property Smarty $_view
 */
require 'modul/seo/model/seo_Site_Model.php';
//require 'modul/infobox/model/infobox_Site_Model.php';

class KompetenciaEdit_Site_Controller extends Page_Edit
{
        
        public $_name='KompetenciaEdit';
        
        
        public function __construct()
        {
                $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);    
                $this->__loadModel('_SiteEdit');
                $this->_model->setClientId($clientId);
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__addEvent('BtnDeleteComp','DeleteComp');
                $this->__addEvent('BtnAddComp','AddComp');
                $this->__addEvent('BtnAddOwnComp','AddOwnComp');
                $this->__run();
        }
        
        public function __show()
        {
                try
                {
                        $lId=Rimo::$_config->SITE_NYELV_ID;
                        $tartalom = Rimo::__loadPublic('model', 'tartalom_Show', 'tartalom');
                        $obj = $tartalom->getTartalomByID(35);
                        $this->_view->assign("text",$obj[0]["tartalom_tartalom"]);
                        
                        $obj = $tartalom->getTartalomByID(40);
                        $this->_view->assign("text2",$obj[0]["tartalom_tartalom"]);
                        
                        $obj = $tartalom->getTartalomByID(41);
                        $this->_view->assign("text3",$obj[0]["tartalom_tartalom"]);
                        
                        
                        $userCompetences = $this->_model->findCompetencesByClientId($lId);
                        $this->_view->assign('userCompetences',$userCompetences);
                        

                        $this->_view->assign('allCompetences',$this->_model->getAllCompetences($lId));
                        
                        
                                               
                        $seo=seo_Site_Model::model()->getSeoItemByKey('competenceEdit',$lId);
                        Rimo::$_site_frame->assign('PageName',$obj[0]["tartalom_cim"]);
                        Rimo::$_site_frame->assign('site_title',$seo['seo_nev']);
                        Rimo::$_site_frame->assign('site_description',$seo['seo_leiras']);
                        Rimo::$_site_frame->assign('site_keywords',$seo['seo_meta_kulcsszo']);
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/kompetencia/view/site.kompetencia_edit.tpl'));
                     
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
        
        public function onClick_DeleteComp() {
            $this->_model->deleteComp(mysql_real_escape_string($_REQUEST['deleteCompId']));
        }
        
        public function onClick_AddComp() {
            $this->_model->addComp(mysql_real_escape_string($_REQUEST['newCompId']));
        }
        
        public function onClick_AddOwnComp() {
            try
            {
                if(!$this->_model->validateCompNev($_REQUEST['addOwnComp']))
                {
                    throw new Exception_Form_Error("Nem megfelelő név! (Min. 5 karakter)");
                }
                elseif($this->_model->checkIfCompExistsByName($_REQUEST['addOwnComp']))
                {
                   throw new Exception_Form_Error("Már létezik ilyen nevű kompetencia!");
                }else
                {
                    $this->_model->addOwnComp(mysql_real_escape_string($_REQUEST['addOwnComp']));
                }
            }
            catch(Exception_MYSQL $e)
            {
                throw new Exception_Form_Error("Hiba történt!");
            } 
        }

}