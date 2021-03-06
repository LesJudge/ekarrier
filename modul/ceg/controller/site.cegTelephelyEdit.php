<?php
require 'modul/seo/model/seo_Site_Model.php';
require 'modul/cim/library/AddressFinder.php';
/**
 * @property Ceg_Telephely_SiteEdit_Model $_model
 * @property Smarty $_view
 */
class CegTelephelyEdit_Site_Controller extends Page_Edit
{

    public $_name = 'TelephelySiteEdit';

    public function __construct()
    {
        $this->__loadModel('_Telephely_SiteEdit');
        $this->_model->setCompanyId(Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id));
        defined(LANG_PageEdit_error_modositas) or define(LANG_PageEdit_error_modositas, 'Az Ön által keresett telephely nem található!');
        defined(LANG_PageEdit_msg_modositas) or define(LANG_PageEdit_msg_modositas, 'Sikeresen módosította az telephelyet!');
        defined(LANG_PageEdit_msg_uj_felvitel) or define(LANG_PageEdit_msg_uj_felvitel, 'Sikeresen mentette az telephelyet!');
        defined(LANG_PageEdit_msg_uj_felvitel_link) or define(LANG_PageEdit_msg_uj_felvitel_link, 'Kattintson ide a megtekintéshez!');
        defined(MYSQL_ERROR_MESSAGE) or define(MYSQL_ERROR_MESSAGE, 'Végzetes hiba lépett fel a művelet során!');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        $routes = Rimo::$_config->routes;
        $lId = Rimo::$_config->SITE_NYELV_ID;
        // SEO
        $seo = seo_Site_Model::model()->getSeoItemByKey('companySiteEdit', $lId);
        // View assign
        $this->_view->assign('routes', $routes);
        Rimo::$_site_frame->assign('Indikator', array(
            1 => array(
                'nev' => 'Cég',
                'link' => Rimo::$_config->DOMAIN . $routes['profile']
            ),
            2 => array(
                'nev' => 'Telephelyek',
                'link' => Rimo::$_config->DOMAIN . $routes['sites']
            ),
            3 => array(
                'nev' => $this->_model->modifyID ? 'Szerkesztés' : 'Új telephely'
            )
        ));
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/ceg/view/site.telephely_edit.tpl'));
    }

    protected function onLoad_Edit_DefaultData()
    {
        try {
            $this->_model->__formValues();
        } catch (Exception_Mysql_Null_Rows $e) {
            throw new Exception_Form_Error(LANG_PageEdit_error_modositas);
        } catch (Exception_MYSQL $e) {
            throw new Exception_Form_Error($e->getMessage());
        }
    }

    public function onClick_New()
    {
        try {
            $this->_model->_DB->prepare('BEGIN')->query_execute();
            $this->_model->__insert();
            $this->onSave_Other($this->_model->insertID);
            $this->_model->_DB->prepare('COMMIT')->query_execute();
            if (!$this->_model->modifyID) {
                $this->formReset();
                $this->onLoad_New();
            } else {
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel_lang);
            }
            if ($this->_model->nyelvID) {
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel . " <a href='" . Rimo::$_config->DOMAIN . "ceg/telephely/szerkesztes/{$this->_model->insertID}?nyelv=" . Rimo::$_config->ADMIN_NYELV_ID . "'>" . LANG_PageEdit_msg_uj_felvitel_link . "</a>");
            } else {
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel . " <a href='" . Rimo::$_config->DOMAIN . "ceg/telephely/szerkesztes/{$this->_model->insertID}'>" . LANG_PageEdit_msg_uj_felvitel_link . "</a>");
            }
        } catch (Exception_MYSQL $e) {
            $this->_model->_DB->prepare('ROLLBACK')->query_execute();
            throw new Exception_Form_Error(MYSQL_ERROR_MESSAGE);
        }
    }

}
