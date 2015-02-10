<?php
require 'modul/allashirdetes/model/AllashirdetesBaseEditModel.php';
require 'library/uniweb/model/AjaxModel.php';
require 'modul/munkakor/model/munkakor_Ajax_Model.php';
/**
 * @property Ceg_Allashirdetes_SiteEdit_Model $_model
 * @property Smarty $_view
 */
class CegAllashirdetesEdit_Site_Controller extends Page_Edit
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'SiteAllashirdetesEdit';
    /**
     * Konstruktor.
     */
    public function __construct()
    {
        $companyId = Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        // Hibaüzenet konstansok definiálása.
        defined(LANG_PageEdit_error_modositas) or define(
            LANG_PageEdit_error_modositas,
            'Az Ön által keresett álláshirdetés nem található!'
        );
        defined(LANG_PageEdit_msg_modositas) or define(
            LANG_PageEdit_msg_modositas,
            'Sikeresen módosította az álláshirdetést!'
        );
        defined(LANG_PageEdit_msg_uj_felvitel) or define(
            LANG_PageEdit_msg_uj_felvitel,
            'Sikeresen mentette az álláshirdetést!'
        );
        defined(LANG_PageEdit_msg_uj_felvitel_link) or define(
            LANG_PageEdit_msg_uj_felvitel_link,
            'Kattintson ide a megtekintéshez!'
        );
        defined(MYSQL_ERROR_MESSAGE) or define(MYSQL_ERROR_MESSAGE, 'Végzetes hiba lépett fel a művelet során!');
        // Inicializálás.
        $this->__loadModel('_Allashirdetes_SiteEdit');
        //try {
            $this->_model->setCompanyId($companyId);
            //$this->_model->setCompanyId('');
            parent::__construct();
            $this->__addParams($this->_model->_params);
            $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
            $this->__run();
        //} catch (Exception $e) {
        //    $this->renderErrorPage($e->getMessage(), false);
        //}
    }
    
    public function renderErrorPage($message, $dev = true)
    {
        if ($dev === true) {
            $em = $message;
        }
        else {
            $em = "Nem várt hiba lépett fel a művelet során!";
        }
        Rimo::$_site_frame->assign('jobError', $em);
        Rimo::$_site_frame->assign(
            'Content',
            Rimo::$_site_frame->fetch('modul/ceg/view/site.allashirdetes_error_page.tpl')
        );
    }
    
    public function __show()
    {
        parent::__show();
        //echo '<pre>', print_r($this->_model->_params, true), '</pre>';
        //exit;
        // Új rekord-e.
        $isNewRecord = (int)$this->_model->modifyID == 0;
        $ma = new \Munkakor_Ajax_Model;
        $this->_view->assign('isNewRecord', $isNewRecord);
        $this->_view->assign('munkakorMain', $ma->findAllMainCategory());
        $this->_view->assign('piAmitKinalunk', Ceg_Allashirdetes_SiteEdit_Model::PI_AMIT_KINALUNK);
        $this->_view->assign('piElvarasok', Ceg_Allashirdetes_SiteEdit_Model::PI_ELVARASOK);
        $this->_view->assign('piFeladatok', Ceg_Allashirdetes_SiteEdit_Model::PI_FELADATOK);
        $this->_view->assign('piTkor', Ceg_Allashirdetes_SiteEdit_Model::PI_TKOR);
        Rimo::$_site_frame->assign('Indikator',
            array(
            1 => array(
                'nev' => 'Cég',
                'link' => Rimo::$_config->DOMAIN . 'ceg/profil/'
            ),
            2 => array(
                'nev' => 'Álláshirdetések',
                'link' => Rimo::$_config->DOMAIN . 'ceg/allashirdetes/',
            ),
            3 => array(
                'nev' => $this->_model->modifyID ? 'Szerkesztés' : 'Új álláshirdetés'
            )
        ));
        Rimo::$_site_frame->assign('PageName', 'Álláshirdetések');
        Rimo::$_site_frame->assign('site_title', 'Álláshirdetések');
        Rimo::$_site_frame->assign('site_description', 'Álláshirdetések');
        Rimo::$_site_frame->assign('site_keywords', 'Álláshirdetések');
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/ceg/view/site.allashirdetes_edit.tpl'));
    }
    
    protected function onLoad_New()
    {
        parent::onLoad_New();
    }
    
    protected function onLoad_Edit_DefaultData()
    {
        try {
            $this->_model->__formValues();
        } catch (Exception_Mysql_Null_Rows $emnr) {
            throw new Exception_Form_Error(LANG_PageEdit_error_modositas);
        } catch (Exception_MYSQL $em) {
            throw new Exception_Form_Error(MYSQL_ERROR_MESSAGE);
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
                //throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel_lang);
                throw new Exception_Form_Message('Sikeresen felvette az álláshirdetést!');
            }
            if ($this->_model->nyelvID) {
                throw new Exception_Form_Message(
                    LANG_PageEdit_msg_uj_felvitel . " <a href='" . Rimo::$_config->DOMAIN
                    .
                    "ceg/allashirdetes/szerkesztes/{$this->_model->insertID}?nyelv="
                    .
                    Rimo::$_config->ADMIN_NYELV_ID . "'>" . LANG_PageEdit_msg_uj_felvitel_link . "</a>"
                );
            } else {
                throw new Exception_Form_Message(
                    LANG_PageEdit_msg_uj_felvitel . " <a href='" . Rimo::$_config->DOMAIN
                    .
                    "ceg/allashirdetes/szerkesztes/{$this->_model->insertID}'>"
                    .
                    LANG_PageEdit_msg_uj_felvitel_link . "</a>"
                );
            }
        } catch (InvalidArgumentException $iae) {
            $this->_model->_DB->prepare('ROLLBACK')->query_execute();
            throw new Exception_Form_Error($iae->getMessage());            
        } catch (Exception_MYSQL $e) {
            $this->_model->_DB->prepare('ROLLBACK')->query_execute();
            throw new Exception_Form_Error(
                'Nem várt hiba lépett fel az álláshirdetés felvitele során! Kérem, próbálja újra!'
            );
        }
    }
    
    public function onClick_Modify()
    {
        try {
            $this->_model->_DB->prepare('BEGIN')->query_execute();
            $this->onSave_Other($this->_model->modifyID);
            $this->_model->__update();
            $this->_model->_DB->prepare('COMMIT')->query_execute();
            throw new Exception_Form_Message('Sikeresen módosította az álláshirdetés!');
        } catch(Exception_MYSQL_Null_Affected_Rows $e) {
            $this->_model->_DB->prepare('COMMIT')->query_execute();
            throw new Exception_Form_Message('Sikeresen módosította az álláshirdetést!');
        } catch (InvalidArgumentException $iae) {
            $this->_model->_DB->prepare('ROLLBACK')->query_execute();
            throw new Exception_Form_Error($iae->getMessage());
            
        } catch(Exception_MYSQL $e) {
            $this->_model->_DB->prepare('ROLLBACK')->query_execute();
            throw new Exception_Form_Error(
                'Nem várt hiba lépett fel az álláshirdetés mentése során! Kérem, próbálja újra!'
            );
        }
    }
}