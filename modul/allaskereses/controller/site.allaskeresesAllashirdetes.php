<?php
require 'modul/ceg/model/CompanyHelperModel.php';
/**
 * @property Smarty $_view
 * @property Allaskereses_Allashirdetes_Model $_model
 */
class AllaskeresesAllashirdetes_Site_Controller extends RimoController
{
    
    public $_name = 'SiteAllashirdetes';
    protected $userCompanyId = 0;
    
    public function __construct()
    {
        $this->_action_type = $_REQUEST;
        $this->init();
        $this->__loadModel('_Allashirdetes');
        $this->__addParams($this->_model->_params);
        $this->__addEvent('BtnMark', 'Mark');
        $this->__addEvent('BtnUnmark', 'Unmark');
        $this->__run();
    }
    
    public function __show()
    {
        parent::__show();
        $pjId = (int)$_GET['allashirdetes_id'];
        $pj = $this->_model->findPostingJobById($pjId);
        $this->_view->assign('pj', $pj);
        // Ha be van jelentkezve a felhasználó, akkor megvizsgálja, hogy megjelölte-e már az álláshirdetést.
        if ($this->isLoggedIn() && !$this->isCompanyUser()) {
            $isMarked = $this->_model->isMarkedByUser(UserLoginOut_Site_Controller::$_id, $pjId);
            $this->_view->assign('isMarked', $isMarked);
            $this->_view->assign('markItText', $isMarked ? 'Jelölés törlése' : 'Álláshirdetés megjelölése');
            $this->_view->assign('pjId', $pjId);
            $this->_view->assign('formUrl', Rimo::$_config->DOMAIN . ltrim($_SERVER['REQUEST_URI'], '/'));
            $markable = true;
        } else {
            $markable = false;
        }
        $this->_view->assign('markable', $markable);
        Rimo::$_site_frame->assign('PageName', 'Álláshirdetés');
        Rimo::$_site_frame->assign('site_title', 'Álláshirdetés');
        Rimo::$_site_frame->assign('site_description', 'Leírás');
        Rimo::$_site_frame->assign('site_keywords', 'meta, keywords');
        Rimo::$_site_frame->assign(
            'Content',
            $this->__generateForm('modul/allaskereses/view/site.allaskereses_allashirdetes_page.tpl')
        );
    }
    /**
     * Megjelöli az álláshirdetést.
     */
    public function onClick_Mark()
    {
        $this->validateMarkRequest();
        try {
            $this->_model->markPostingJob(UserLoginOut_Site_Controller::$_id, $_POST['postingJobId']);
            throw new Exception_Form_Message('Sikeresen megjelölte az álláshirdetést!');
        } catch (Exception_MYSQL $em) {
            //throw new Exception_MYSQL('Végzetes hiba történt! Kérem, próbálja újra!');
        }
    }
    /**
     * Leveszi a jelölést az adott álláshirdetésről.
     */
    public function onClick_Unmark()
    {
        $this->validateMarkRequest();
        try {
            $this->_model->unmarkPostingJob(UserLoginOut_Site_Controller::$_id, $_POST['postingJobId']);
            throw new Exception_Form_Message('Sikeresen törölte az álláshirdetés megjelölését!');
        } catch (Exception_MYSQL $em) {
            throw new Exception_Action_error('Végzetes hiba történt! Kérem, próbálja újra!');
        }
    }
    /**
     * Megvizsgálja, hogy a jelölés kérése megfelelő-e.
     * @return boolean
     */
    protected function validateMarkRequest()
    {
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
    {
        if ($this->isLoggedIn()) {
            $this->userCompanyId = (int)CompanyHelperModel::model()->findCompanyByUserId(
                UserLoginOut_Site_Controller::$_id
            );
        } 
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