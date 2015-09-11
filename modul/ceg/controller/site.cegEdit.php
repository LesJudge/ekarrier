<?php
include_once "page/all/controller/page.edit.php";
require 'library/uniweb/AttachableUserController.php';
include_once "page/admin/model/admin.edit_model.php";
include_once "modul/email/site.email.php";
require 'modul/seo/model/seo_Site_Model.php';
require 'modul/user/library/model/BaseAdminUserEditModel.php';
require 'library/uniweb/modul/ModelEditHelper.php';
require 'library/uniweb/AttachedUserInterface.php';
require 'library/uniweb/AttachedUser.php';
require 'library/uniweb/AttachedUserInsertInterface.php';
require 'library/uniweb/AttachedUserInsert.php';
require 'library/uniweb/AttachedUserUpdateInterface.php';
require 'library/uniweb/AttachedUserUpdate.php';
require 'library/uniweb/AttachedUserFinderInterface.php';
require 'library/uniweb/AttachableUserModelInterface.php';
require 'library/uniweb/AttachableUserModelAbstract.php';
require 'modul/ceg/library/SiteCegEditInsert.php';
require 'modul/ceg/library/SiteCegEditUpdate.php';
require 'modul/ceg/library/SiteCegEditFinder.php';
require 'modul/user/library/UserHirlevelHelper.php';
require 'modul/cim/library/AddressFinder.php';
/**
 * @property Ceg_SiteEdit_Model $_model
 * @property Smarty $_view
 */
class CegEdit_Site_Controller extends AttachableUserController
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'CegSiteEdit';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;
    
    public function __construct()
    {
        $this->__loadModel('_SiteEdit');
        if (UserLoginOut_Controller::$_id) {
            $this->_model->setAttachedId(Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id));
            $_REQUEST['id'] = UserLoginOut_Controller::$_id;
        }else{
            if($_SESSION['type']=='mv'){
                header('Location: ' . Rimo::getConfig()->DOMAIN);
            }
        }
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__addEvent('BtnDeleteFile', 'DeleteFile');
        $this->__run();
    }
    
    public function __show()
    {
        parent::__show();
        $lId = Rimo::$_config->SITE_NYELV_ID; // Nyelv azonosító
        $registration = $this->_model->modifyID > 0 ? false : true; // Regisztráció
        
        $seoKey = $registration ? 'companyRegistration' : 'companyEdit'; // SEO kulcs
        $view = $registration ? 'modul/ceg/view/site.ceg_regisztracio.tpl' : 'modul/ceg/view/site.ceg_edit.tpl'; // View
        $btnSaveLabel = $registration ? 'Regisztráció' : 'Mentés';
        // SEO tömb.
        $seo = seo_Site_Model::model()->getSeoItemByKey($seoKey, $lId);
        // Render
        $this->_view->assign('btnSaveLabel', $btnSaveLabel);
        Rimo::$_site_frame->assign('Indikator', array(
            0 => array('nev' => 'Cég regisztráció')
        ));
        
        $tartalom_show_model = $this->__loadPublicModel('tartalom', '_Show');
        //$this->_view->assign('regcontent',$tartalom_show_model->getTartalomFromID(21));
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content', $this->__generateForm($view));
    }
    
    protected function onLoad_Edit_DefaultData()
    {
        try {
            $this->_model->__formValues();
        } catch (Exception_Mysql_Null_Rows $e) {
            throw new \Exception_404;
        } catch (Exception_MYSQL $e) {
            throw new \Exception_404;
        }
    }
    
    public function createEmailData(array $params)
    {
        return array(
            'felhasznalonev' => $params['TxtFnev']->_value,
            'jelszo' => $params['Password']->_value,
            'cegnev' => $params['TxtCegnev']->_value,
            'kapcsolattarto_tel' => $params['TxtKtoTel']->_value,
            'kapcsolattarto_email' => $params['TxtEmail']->_value,
            'ceg_kapcsolattarto_vezeteknev' => $params['TxtVnev']->_value,
            'ceg_kapcsolattarto_keresztnev' => $params['TxtKnev']->_value
        );
    }

    public function getEmailAddress()
    {
        return $this->_params['TxtEmail']->_value;
    }
    
    public function getEmailid()
    {
        return 2;
    }
    
    public function getInsertFailMessage()
    {
        return 'Nem várt hiba lépett fel a művelet során! Kérem, próbálja újra!';
    }

    public function getInsertSuccessMessage()
    {
        return 'Sikeres regisztráció! Kérjük regisztrációját erősítse meg az e-mail címére elküldött megerősítő 
            e-mailben található link segítségével!';
    }

    public function getUpdateFailMessage()
    {
        return 'Nem várt hiba lépett fel a művelet során! Kérem, próbálja újra!';
    }

    public function getUpdateSuccessMessage()
    {
        return 'Sikeresen módosította az adatait!';
    }
}