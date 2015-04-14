<?php

/**
 * @property Ceg_ShowCeg_Model $_model
 * @property Smarty $_view
 */

class CegShow_Site_Controller extends Page_Edit {

    public $name = 'Ceg';

    public function __construct()
    {
        $this->__loadModel('_ShowCeg');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addEvent('BtnAddLink', 'addLink');
        $this->__addEvent('BtnDeleteLink', 'deleteLink');
        $this->__run();
    }

    public function __show() 
    {
        try {
            $lId = Rimo::$_config->SITE_NYELV_ID;
            // Lekérdezi a cég adatait.
            $companyData = $this->_model->findCompanyByUrl($_GET['link'], $lId);
            $this->_view->assign('companyData', $companyData);
            // telephelyek
            $telephelyek = $this->_model->getCompanyTelephelyek($companyData['ceg_id']);
            $this->_view->assign('sites', $telephelyek);
            // Lekérdezi a céghez tartozó álláshirdetéseket.
            $jobs = $this->_model->findJobsByCompanyId($companyData['ceg_id'], $lId);
            $this->_view->assign('jobs', $jobs);
            // Megtekintések számának növelése.
            if ($_COOKIE['ceg_megtekintes'] != $companyData['ceg_id']) {
                $this->_model->updateViews($companyData['ceg_id'], $lId);
            }
            setcookie('ceg_megtekintes', $companyData['ceg_id'], time() + 300);
            // Render
            Rimo::$_site_frame->assign('PageName', $companyData['ceg_nev']);
            Rimo::$_site_frame->assign('Indikator', array(
                1 => array(
                    'nev' => 'Munkáltatók',
                    'link' => Rimo::$_config->DOMAIN . 'munkaltatok/'
                ),
                2 => array(
                    'nev' => $companyData['ceg_nev'],
                )
            ));

            try
            {
                $clientId = Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id);
            }catch(Exception_MYSQL_Null_Rows $e){
            }

            Rimo::$_site_frame->assign('site_title', 'Munkáltatók - ' . $companyData['nev']);
            Rimo::$_site_frame->assign('site_description', $companyData['leiras']);
            Rimo::$_site_frame->assign('site_keywords', $companyData['meta_kulcsszo']);
            Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/ceg/view/site.ceg_show.tpl'));
        } catch (Exception_MYSQL_Null_Rows $e) {
            throw new Exception_404;
        }
    }
    
   
}