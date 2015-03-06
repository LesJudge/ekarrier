<?php
require 'modul/allashirdetes/model/AllashirdetesBaseEditModel.php';
require 'modul/allashirdetes/model/allashirdetes_Edit_Model.php';
/**
 * @property Smarty $_view
 * @property Allaskereses_Allashirdetes_Model $_model
 */
class AllashirdetesShow_Site_Controller extends RimoController
{
    /**
     * Controller neve a $_SESSION szuperglobálisban.
     * @var string
     */
    public $_name = 'SiteAllashirdetesShow';
    /**
     * Felhasználóhoz tartozó cég azonosító.
     * @var int
     */
    protected $userCompanyId = 0;
    /**
     * Constructor
     */
    public function __construct()
    {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->_action_type = $_REQUEST;
        //$this->init();
        $this->__loadModel('_Site_Show');
        $this->__addParams($this->_model->_params);
        $this->__addEvent('BtnMark', 'Mark');
        $this->__addEvent('BtnUnmark', 'Unmark');
        $this->__addEvent('BtnFavourite', 'Favourite');
        $this->__addEvent('BtnUnfavourite', 'Unfavourite');
        
        $this->__run();
    }
    /**
     * Render
     */
    public function __show()
    {
        try {
            parent::__show();
            $pjId = (int)$_GET['allashirdetes_id'];
            $pj = $this->_model->findPostingJobById($pjId);
            $aem = new Allashirdetes_Edit_Model;
            $this->_view->assign('elvarasok', $aem->findElvarasByJobId($pjId));
            $this->_view->assign('feladatok', $aem->findFeladatByJobId($pjId));
            $this->_view->assign('kompetenciak', $aem->findKompetenciaByJobId($pjId));
            $this->_view->assign('amitKinalunk', $aem->findAmitKinalunkByJobId($pjId));
            $this->_view->assign('pj', $pj);
            
            // Ha be van jelentkezve a felhasználó, akkor megvizsgálja, hogy megjelölte-e már az álláshirdetést.
            if ($this->isLoggedIn() && !$this->isCompanyUser()) {
                
                //Megjelölve-e
                $isMarked = $this->_model->isMarkedByUser(Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id), $pjId);
                
                //Kedvenc-e
                $isFavourited = $this->_model->isFavouritedByUser(Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id), $pjId);
                
                $this->_view->assign('isMarked', $isMarked);
                $this->_view->assign('markItText', $isMarked ? 'Jelölés törlése' : 'Álláshirdetés megjelölése');
                
                $this->_view->assign('isFavourited', $isFavourited);
                $this->_view->assign('favouriteItText', $isFavourited ? 'Eltávolítás a kedvencek közül' : 'Mentés a kedvencek közé');
                
                $this->_view->assign('pjId', $pjId);
                $this->_view->assign('formUrl', Rimo::$_config->DOMAIN . ltrim($_SERVER['REQUEST_URI'], '/'));
                $this->_view->assign('kompetenciaRajzok', $this->_model->findKompetenciaRajzokByUgyfelID(Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id)));
                
                $favouritable = true;
                $markable = true;
            } else {
                $markable = false;
                $favouritable = false;
            }
            
            $this->_view->assign('markable', $markable);
            Rimo::$_site_frame->assign('PageName', 'Álláshirdetés');
            Rimo::$_site_frame->assign('site_title', 'Álláshirdetés');
            Rimo::$_site_frame->assign('site_description', 'Leírás');
            Rimo::$_site_frame->assign('site_keywords', 'meta, keywords');
            Rimo::$_site_frame->assign(
                'Content',
                $this->__generateForm(
                    'modul/' . Rimo::$_config->APP_PATH . '/view/site.allashirdetes_show.tpl'
                )
            );
        } catch (Exception_MYSQL $e) {
            throw new Exception_404;
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            throw new Exception_404;
        }
    }
    /**
     * Megjelöli az álláshirdetést.
     */
    public function onClick_Mark()
    {
        
        $this->validateMarkRequest();
        try {
            $this->_model->markPostingJob(
                Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id), 
                $_POST['postingJobId'],
                $_POST['kRajzok']
                    
            );
            throw new Exception_Form_Message('Sikeresen megjelölte az álláshirdetést!');
        } catch (Exception_MYSQL $em) {
            throw new Exception_Form_Message('Végzetes hiba történt! Kérem, próbálja újra!');
        }
    }
    /**
     * Leveszi a jelölést az adott álláshirdetésről.
     */
    public function onClick_Unmark()
    {
        $this->validateMarkRequest("unmark");
        try {
            $this->_model->unmarkPostingJob(Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id), 
                $_POST['postingJobId']
            );
            throw new Exception_Form_Message('Sikeresen törölte az álláshirdetés megjelölését!');
        } catch (Exception_MYSQL $em) {
            throw new Exception_Form_Message('Végzetes hiba történt! Kérem, próbálja újra!');
        }
    }
    
     public function onClick_Favourite()
    {
        
        $this->validateMarkRequest("fav");
        try {
            $this->_model->favouritePostingJob(
                Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id), 
                $_POST['postingJobId']
            );
            throw new Exception_Form_Message('Sikeres hozzáadás a kedvencekhez!');
        } catch (Exception_MYSQL $em) {
            throw new Exception_Form_Message('Végzetes hiba történt! Kérem, próbálja újra!');
        }
    }
   
    
    public function onClick_Unfavourite()
    {
        $this->validateMarkRequest("fav");
        try {
            $this->_model->unfavouritePostingJob(Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id), 
                $_POST['postingJobId']
            );
            throw new Exception_Form_Message('Sikeresen törölte az álláshirdetést a kedvencek közül!');
        } catch (Exception_MYSQL $em) {
            throw new Exception_Form_Message('Végzetes hiba történt! Kérem, próbálja újra!');
        }
    }
    /**
     * Megvizsgálja, hogy a jelölés kérése megfelelő-e.
     * @return boolean
     */
    protected function validateMarkRequest($mod = "default")
    {
        if ($mod == "default")
        {
            if((int)$_POST['kRajzok'] < 1)
            {
                throw new Exception_Action_error('Nem választott kompetenciarajzot!');
            }
            
            if(
                $this->isLoggedIn()
                && 
                !$this->isCompanyUser()
                &&
                isset($_POST['postingJobId'])
                &&
                (int)$_POST['postingJobId'] > 0
            ) {
                return true;
            } else {
                throw new Exception_Action_error('Nem várt hiba lépett fel a művelet során!');
            }
        } else {
            if(
                $this->isLoggedIn()
                && 
                !$this->isCompanyUser()
                &&
                isset($_POST['postingJobId'])
                &&
                (int)$_POST['postingJobId'] > 0
            ) {
                return true;
            } else {
                throw new Exception_Action_error('Nem várt hiba lépett fel a művelet során!');
            }
        }
        
    }
    /**
     * Megvizsgálja, hogy a felhasználó céghez tartozik-e.
     * @return boolean
     */
    protected function isCompanyUser()
    {
        return ((int)$this->userCompanyId > 0) ? true : false;
    }
    /**
     * Controller inicializálása.
     */
    protected function init()
    {/*
        if ($this->isLoggedIn()) {
            $this->userCompanyId = (int)CompanyHelperModel::model()->findCompanyByUserId(
                UserLoginOut_Site_Controller::$_id
            );
        }*/ 
    }
    /**
     * Megvizsgálja, hogy a felhasználó be van-e jelentkezve.
     * @return boolean
     */
    protected function isLoggedIn()
    {
        return (int)UserLoginOut_Site_Controller::$_id > 0;
    }
}