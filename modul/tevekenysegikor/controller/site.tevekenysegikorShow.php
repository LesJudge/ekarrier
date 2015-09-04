<?php

//class MunkakorShowMunkakor_Site_Controller extends RimoController
//include_once 'page/admin/controller/admin.edit.php';
//include_once 'page/admin/model/admin.edit_model.php';
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
        $this->__addEvent('BtnAddDescriptionComment', 'addComment');
        $this->__addEvent('BtnAddExpComment', 'addExpComment');
        $this->__addEvent('BtnAddTasksComment', 'addTasksComment');
        $this->__addEvent('BtnAddCompComment', 'addCompComment');
        
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
            
            $tartalom = Rimo::__loadPublic('model', 'tartalom_Show', 'tartalom');
            $obj = $tartalom->getTartalomByID(26);
            $this->_view->assign("text",$obj[0]["tartalom_tartalom"]);
            
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
            
            // Akik megjelölték - összesítve hozza azokat az ügyfeleket akik az adott tev.kört megjelölték vagy a tevkör alá besorolt munkakörhöz kapcsolodó álláshirdetéseket megjelölték
            $markers = $this->_model->findMarkersByJobId($jobData['ID']);
            $this->_view->assign('markers', $markers);
            
            // Ügyfél kompetenciarajzai
            $this->_view->assign('kompetenciaRajzok', $this->_model->findKompetenciaRajzokByUgyfelID($clientId));
           
                       
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
            
            //Kommentek és kommentelés a tevkörhöz - leírás
           if(isset($_GET['descriptiondetails']))
           {
               unset($_GET);
               $this->_view->assign('descriptionDetails', '1');
               $descriptionComments = $this->_model->findCommentsByTevkorID($jobData['ID'],'desc');
               $this->_view->assign('descriptionComments', $descriptionComments);
           }
           
           //Kommentek és kommentelés a tevkörhöz - elvárások
           if(isset($_GET['expdetails']))
           {
               unset($_GET);
               $this->_view->assign('expDetails', '1');
               $expComments = $this->_model->findCommentsByTevkorID($jobData['ID'],'exp');
               $this->_view->assign('expComments', $expComments);
           }
           
           //Kommentek és kommentelés a tevkörhöz - feladatok
           if(isset($_GET['tasksdetails']))
           {
               unset($_GET);
               $this->_view->assign('tasksDetails', '1');
               $tasksComments = $this->_model->findCommentsByTevkorID($jobData['ID'],'tasks');
               $this->_view->assign('tasksComments', $tasksComments);
           }
           
           //Kommentek és kommentelés a tevkörhöz - kompetenciák
           if(isset($_GET['compdetails']))
           {
               unset($_GET);
               $this->_view->assign('compDetails', '1');
               $compComments = $this->_model->findCommentsByTevkorID($jobData['ID'],'comp');
               $this->_view->assign('compComments', $compComments);
           }
           
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
        
            if(!empty($_REQUEST['descriptionComment']))
            {
                $this->_model->addComment((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $jobData['ID'],$_REQUEST['descriptionComment'], 'desc');
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
    
    public function onClick_addExpComment() {
        try{
            $lId = Rimo::$_config->SITE_NYELV_ID;
            $jobData = $this->_model->findTevkorByUrl($_GET['link'], $lId);
        
            if(!empty($_REQUEST['expComment']))
            {
                $this->_model->addComment((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $jobData['ID'],$_REQUEST['expComment'], 'exp');
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
    
    public function onClick_addTasksComment() {
        try{
            $lId = Rimo::$_config->SITE_NYELV_ID;
            $jobData = $this->_model->findTevkorByUrl($_GET['link'], $lId);
        
            if(!empty($_REQUEST['tasksComment']))
            {
                $this->_model->addComment((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $jobData['ID'],$_REQUEST['tasksComment'], 'tasks');
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
    
    public function onClick_addCompComment() {
        try{
            $lId = Rimo::$_config->SITE_NYELV_ID;
            $jobData = $this->_model->findTevkorByUrl($_GET['link'], $lId);
        
            if(!empty($_REQUEST['compComment']))
            {
                $this->_model->addComment((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $jobData['ID'],$_REQUEST['compComment'], 'comp');
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
    
}