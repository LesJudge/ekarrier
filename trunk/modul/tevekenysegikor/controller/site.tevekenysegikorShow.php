<?php
/**
 * @property Munkakor_ShowMunkakor_Model $_model
 * @property Smarty $_view
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
//class MunkakorShowMunkakor_Site_Controller extends RimoController
//include_once 'page/admin/controller/admin.edit.php';
//include_once 'page/admin/model/admin.edit_model.php';
require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
class TevekenysegikorShow_Site_Controller extends Page_Edit
{
    /**
     * Controller neve a $_SESSION szuperglobálisban.
     * @var string
     */
    public $_name = 'SiteTevekenysegikor';
    /**
     * Constructor
     */
    public function __construct()
    {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);        
        $this->__loadModel('_Show');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addEvent('BtnAddTevekenysegikor', 'addTevekenysegikor');
        $this->__addEvent('BtnRemoveTevekenysegikor', 'removeTevekenysegikor');
        $this->__addEvent('BtnAddComment', 'addComment');
        $this->__addEvent('BtnAddLink', 'addLink');
        $this->__addEvent('BtnDeleteLink', 'deleteLink');
        
        $this->__run();
    }
    /**
     * Render
     * @throws Exception_404
     */
    public function __show()
    {
        try {
            $lId = Rimo::$_config->SITE_NYELV_ID;
            
            $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
            
            // Lekérdezi a tevkör adatait.
            $jobData = $this->_model->findTevkorByUrl($_GET['link'], $lId);
            $this->_view->assign('jobData', $jobData);
            
            // Munkakörök
            $munkaKorok = $this->_model->findMunkakorokByID($jobData['ID']);
            $this->_view->assign('munkakorok', $munkaKorok);
            
            // Feladatok
            $this->_view->assign('feladatok', $this->_model->findFeladatok($jobData['ID']));
            
            // Elvárások
            $this->_view->assign('elvarasok', $this->_model->findElvarasok($jobData['ID']));
            
            // Kompetenciák
            $this->_view->assign('kompetenciak', $this->_model->findKompetenciak($jobData['ID']));
            
            // Álláshirdetések
            $offers = $this->_model->findOffersByJobId($jobData['ID']);
            $this->_view->assign('offers', $offers);
            
            // Akik megjelölték
            $markers = $this->_model->findMarkersByJobId($jobData['ID']);
            $this->_view->assign('markers', $markers);
            
            // Ügyfél kompetenciarajzai
            $this->_view->assign('kompetenciaRajzok', $this->_model->findKompetenciaRajzokByUgyfelID($clientId));
           
            // Linkek
            $links = ugyfellinkek_Site_Model::model()->findLinks($clientId);  
            $this->_view->assign("linkMode","on");
            $this->_view->assign("addLinkOption","on");
            $this->_view->assign("links",$links);
           
            // Ha az ügyfél megjelölte
            if($this->_model->checkIfMarkedByUgyfel($clientId,$jobData['ID']) == false)
            {
                $this->_view->assign('marked', 'unmarked');
            // Ha még nem jelölte meg
            }elseif(is_array($this->_model->checkIfMarkedByUgyfel($clientId,$jobData['ID'])))
            {
               $this->_view->assign('marked', 'marked');
               $kompRajz = $this->_model->checkIfMarkedByUgyfel($clientId,$jobData['ID']);
               $this->_view->assign('markedWithCompRajz', $kompRajz["nev"]);
            }
            
            //Kommentek és kommentelés a tevkörhöz
           if(isset($_GET['details']))
           {
               $this->_view->assign('details', '1');
               $comments = $this->_model->findCommentsByTevkorID($jobData['ID']);
               $this->_view->assign('comments', $comments);
           }
           
            // Tooltipek átadása a nézetnek.
            //$this->_view->assign('tooltips', Rimo::$_config->tooltips);
            //$this->_view->assign('activeTooltip', 2);
            
            // Megtekintés növelése.
            if ($_COOKIE['tevekenysegikor_megtekintes'] != $jobData['ID']) {
                $this->_model->updateViewed($jobData['ID'], $lId);
            }
            setcookie('tevekenysegikor_megtekintes', $jobData['ID'], time() + 300);
            
            // Render
            Rimo::$_site_frame->assign('PageName', $jobData['Cim']);
            Rimo::$_site_frame->assign('Indikator', array());
            Rimo::$_site_frame->assign('site_title', $jobData['Cim']);
            Rimo::$_site_frame->assign('site_description', $jobData['Leiras']);
            Rimo::$_site_frame->assign('site_keywords', $jobData['kategoria_meta_kulcsszo']);
            Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/tevekenysegikor/view/site.tevekenysegikor_show.tpl'));
        } catch (Exception_MYSQL $em) {
            throw new Exception_404;
        }  catch (Exception_MYSQL_Null_Rows $emnr) {
            throw new Exception_404;
        }
    }
    
    public function onClick_addTevekenysegikor() {
        $lId = Rimo::$_config->SITE_NYELV_ID;
        $jobData = $this->_model->findTevkorByUrl($_GET['link'], $lId);
        $valid = $this->_model->validateMarking((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $jobData['ID'],(int)$_REQUEST['kRajzok']);
        if($valid === true)
        {
            $this->_model->addTevekenysegikor((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $jobData['ID'],(int)$_REQUEST['kRajzok']);
            throw new Exception_Form_Message('Sikeres jelentkezés!');
        }
        else
        {
            throw new Exception_Form_Error($valid);
        }
    }
    
    public function onClick_removeTevekenysegikor() {
        try
        {
            $lId = Rimo::$_config->SITE_NYELV_ID;
            $jobData = $this->_model->findTevkorByUrl($_GET['link'], $lId);
            $this->_model->removeTevekenysegikor((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $jobData['ID']);
            throw new Exception_Form_Message('Sikeres eltávolítás!');
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
    }
    
    public function onClick_addComment() {
        try{
            $lId = Rimo::$_config->SITE_NYELV_ID;
            $jobData = $this->_model->findTevkorByUrl($_GET['link'], $lId);
        
            if(!empty($_REQUEST['comment']))
            {
                $this->_model->addComment((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $jobData['ID'],$_REQUEST['comment']);
                throw new Exception_Form_Message('Üzenet elküldve!');
            }
            else
            {
                throw new Exception_Form_Error("Írjon be szöveget!");
            }
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }  
    }
    
    public function onClick_addLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $lId = Rimo::$_config->SITE_NYELV_ID;
        $jobData = $this->_model->findTevkorByUrl($_GET['link'], $lId);
        ugyfellinkek_Site_Model::model()->validateSaveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."tevekenysegikor/".$jobData['Link']);
        ugyfellinkek_Site_Model::model()->saveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."tevekenysegikor/".$jobData['Link']);
    }
    
    public function onClick_deleteLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        ugyfellinkek_Site_Model::model()->validateDeleteLink($clientId, $_REQUEST['delLink']);
        ugyfellinkek_Site_Model::model()->deleteLink($clientId, $_REQUEST['delLink']);
    }
    
}