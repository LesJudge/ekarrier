<?php
include_once "page/all/controller/page.edit.php";
require 'library/uniweb/AttachableUserController.php';
include_once "page/admin/model/admin.edit_model.php";
include_once "modul/email/site.email.php";
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
require 'modul/user/library/SiteUserEditInsert.php';
require 'modul/user/library/SiteUserEditUpdate.php';
require 'modul/user/library/SiteUserEditDataFinder.php';
require 'modul/user/library/UserHirlevelHelper.php';
require 'modul/cim/library/AddressFinder.php';
/**
 * @property User_SiteEdit_Model $_model Model.
 */
class UserReg_Site_Controller extends AttachableUserController
{
    /**
     * Form neve.
     * @var string
     */
    public $_name = 'UserSiteEdit';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;
    /**
     * Konstruktor.
     */
    public function __construct()
    {
        $this->__loadModel('_SiteEdit');
        if (UserLoginOut_Controller::$_id) {
            $this->_model->setAttachedId(Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id));
            $_REQUEST['id'] = UserLoginOut_Controller::$_id;
        }else{
            if($_SESSION['type']=='ma'){
                header('Location: ' . Rimo::getConfig()->DOMAIN);
            }
        }
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__addEvent('BtnDeleteFile', 'DeleteFile');
        $this->__run();
    }
    /**
     * Form megjelenítése.
     */
    public function __show()
    {
        parent::__show();
        $this->_view->assign('kep_max_size', Create::byte_converter($this->_params['File']->_verify['maxsize']));
        $tartalom_show_model = $this->__loadPublicModel('tartalom', '_Show');
        if (!$this->_model->modifyID) {
            $data = $tartalom_show_model->getTartalomByID(4);
            $this->_view->assign('altalanos_szerzodesi_feltetelek', $data[0]['tartalom_tartalom']);
            $data = $tartalom_show_model->getTartalomFromID(5);
            $this->_view->assign('regcontent',$tartalom_show_model->getTartalomFromID(14));
            $this->_view->assign('passwordRequired', true);
        }
        else {
            $data = $tartalom_show_model->getTartalomFromID(8);
            $this->_view->assign('passwordRequired', false);
        }
        Rimo::$_site_frame->assign('Indikator', array(1 => array('nev' => $data[0]['tartalom_cim'])));
        Rimo::$_site_frame->assign('PageName', $data[0]['tartalom_cim']);
        Rimo::$_site_frame->assign('site_title', $data[0]['tartalom_cim']);
        Rimo::$_site_frame->assign('site_description', $data[0]['tartalom_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $data[0]['tartalom_meta_kulcsszo']);
        $this->_view->assign('regisztracio_oldal', $data[0]['tartalom_tartalom']);
        if ($this->_model->modifyID) {
            Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/user/view/site.user_edit.tpl'));
        }
        else {
            Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/user/view/site.user_reg.tpl'));
        }
    }
    /**
     * Események végrehajtása.
     */
    public function __runEvents()
    {
        $this->_model->setDefaultVal();
        parent::__runEvents();
    }
    /**
     * Kép törlése.
     * @throws Exception_Form_Message
     */
    public function onClick_DeleteFile()
    {
        $this->_model->deleteKep($this->_events["BtnDeleteFile"]->_value);
        throw new Exception_Form_Message("Sikeresen törölte a képet.");
    }
    /**
     * Form reset.
     * @param boolean $torles Törölje-e az input mezők értékeit.
     */
    public function formReset($torles=false)
    {
        if($torles) {
            parent::formReset();
        }
    }
    
    public function createEmailData(array $params)
    {
        return array(
            'felhasznalonev' => $params['TxtFnev']->_value,
            'jelszo' => $params['Password']->_value,
            'email' => $params['TxtEmail']->_value,
            'vezetek_nev' => $params['TxtVnev']->_value,
            'kereszt_nev' => $params['TxtKnev']->_value
        );
    }

    public function getEmailAddress()
    {
        return $this->_params['TxtEmail']->_value;
    }
    
    public function getEmailid()
    {
        return 1;
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