<?php
require 'modul/seo/model/seo_Site_Model.php';
/**
 * @property User_Vegzettseg_SiteEdit_Model $_model
 * @property Smarty $_view
 */
class UserVegzettsegEdit_Site_Controller extends Page_Edit
{
    const MSG_ERROR_NOT_FOUND = 'Az Ön által keresett végzettség nem található!';
    const MSG_ERROR_SQL = 'Végzetes hiba lépett fel a művelet során!';
    const MSG_SUCCESS_INSERT = 'Sikeresen mentette a végzettséget!';
    const MSG_SUCCESS_UPDATE = 'Sikeresen módosította a végzettséget!';
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'VegzettsegEdit';
    /**
     * SEO Site model.
     * @var seo_Site_Model
     */
    public $seo;
    /**
     * Konstruktor.
     */
    public function __construct()
    {
        $clientId = Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        defined(LANG_PageEdit_msg_modositas) or define(LANG_PageEdit_msg_modositas,'Sikeresen módosította a végzettséget!');
        defined(LANG_PageEdit_msg_uj_felvitel) or define(LANG_PageEdit_msg_uj_felvitel,'Sikeresen mentette a végzettséget!');
        defined(LANG_PageEdit_msg_uj_felvitel_link) or define(LANG_PageEdit_msg_uj_felvitel_link,'Kattintson ide a megtekintéshez!');
        $this->__loadModel('_Vegzettseg_SiteEdit');
        $this->_model->setClientId($clientId);
        $this->seo = new seo_Site_Model;
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    /**
     * Form megjelenítése.
     */
    public function __show()
    {
        parent::__show();
        $seo = $this->seo->findSeoItemByKey('editQualification');
        Rimo::$_site_frame->assign('Indikator', array(
            1 => array(
                'nev' => 'Profil',
                'link' => Rimo::$_config->DOMAIN . 'profil/'
            ),
            2 => array(
                'nev' => 'Végzettségeim',
                'link' => Rimo::$_config->DOMAIN . 'profil/vegzettsegeim/',
            ),
            3 => array(
                'nev' => $this->_model->modifyID ? 'Szerkesztés' : 'Új végzettség'
            )
        ));
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/user/view/site.user_vegzettseg_edit.tpl'));
    }

    protected function onLoad_Edit_DefaultData()
    {
        try {
            $this->_model->__formValues();          
        } catch(Exception_Mysql_Null_Rows $emnr) {
            throw new Exception_Form_Error(self::MSG_ERROR_NOT_FOUND);
        } catch(Exception_MYSQL $em) {
            throw new Exception_Form_Error(self::MSG_ERROR_SQL);
        }
    }

    public function onClick_New()
    {
        try {
            $this->_model->_DB->prepare('BEGIN')->query_execute();
            $this->_model->__insert();
            $this->onSave_Other($this->_model->insertID);
            $this->_model->_DB->prepare('COMMIT')->query_execute();
            throw new Exception_Form_Message(self::MSG_SUCCESS_INSERT . ' <a href="' . Rimo::$_config->DOMAIN. 
                    'profil/vegzettsegeim/szerkesztes/' . $this->_model->insertID . '">
                    A megtekintéshez kattintson ide!</a>');
        } catch(Exception_MYSQL $em) {
            $this->_model->_DB->prepare('ROLLBACK')->query_execute();
            throw new Exception_Form_Error(self::MSG_ERROR_SQL);
        }
    }
    
    public function onClick_Modify()
    {
        try {
            $this->_model->_DB->prepare('BEGIN')->query_execute();
            $this->onSave_Other($this->_model->modifyID);
            $this->_model->__update();
            $this->_model->_DB->prepare('COMMIT')->query_execute();
            throw new Exception_Form_Message(self::MSG_SUCCESS_UPDATE);
        } catch(Exception_MYSQL_Null_Affected_Rows $emnr) {
            $this->_model->_DB->prepare('COMMIT')->query_execute();
            throw new Exception_Form_Message(self::MSG_SUCCESS_UPDATE);
        } catch(Exception_MYSQL $em) {
            $this->_model->_DB->prepare('ROLLBACK')->query_execute();
            throw new Exception_Form_Error(self::MSG_ERROR_SQL);
        }
    }
}