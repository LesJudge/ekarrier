<?php
require 'page/all/controller/page.list.php';
require 'modul/seo/model/seo_Site_Model.php';
/**
 * @property Ceg_TelephelyList_Model $_model
 * @property Smarty $_view
 */
class CegTelephelyList_Site_Controller extends Page_List
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'TelephelyList';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;

    public function __construct()
    {
        $companyId = (int)Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        // Constant definitions
        defined(LANG_PageList_nincs_elem) or define(LANG_PageList_nincs_elem, 'Nincs megjeleníthető telephely');
        // Loads model
        $this->__loadModel('_Telephely_SiteList');
        // WHERE
        $this->_model->listWhere['compIdWhere'] = 'ceg_id = ' . $companyId;
        // Construct
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
        
    public function __show()
    {
        parent::__show();
        $routes = Rimo::$_config->routes;
        $lId = Rimo::$_config->SITE_NYELV_ID;
        // SEO
        $seo = seo_Site_Model::model()->getSeoItemByKey('companySiteList', $lId);
        // View assign
        $this->_view->assign('routes', $routes);
        // Site frame
        Rimo::$_site_frame->assign('Indikator', array(
            1 => array('nev' => 'Cég', 'link' => Rimo::$_config->DOMAIN . $routes['adatmodositas']),
            2 => array('nev' => $seo['seo_nev'])
        ));
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/ceg/view/site.telephely_list.tpl'));
    }
        
}