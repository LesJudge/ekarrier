<?php
//require 'page/all/controller/page.list.php';
/**
 * @property Ceg_AllashirdetesList_Model $_model
 * @property Smarty $_view
 */
class CegAllashirdetesList_Site_Controller extends Page_List
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'SiteAllashirdetesList';
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
        $companyId = Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        // NULL sor hibaüzenet konstans definiálása.
        defined(LANG_PageList_nincs_elem) or define(LANG_PageList_nincs_elem, 'Nincs megjeleníthető álláshirdetés!');
        // Inicializálás.
        $this->__loadModel('_Allashirdetes_SiteList');
        $this->_model->listWhere['cegIdWhere'] = 'ceg_id=' . (int) $companyId;
        
       
            $this->_model->_fields.=", COUNT(ugyfel_attr_allashirdetes_megjelolt.ugyfel_id) AS megjelolesDB";
            $this->_model->_join.=" LEFT JOIN ugyfel_attr_allashirdetes_megjelolt ON ugyfel_attr_allashirdetes_megjelolt.allashirdetes_id = allashirdetes.allashirdetes_id";
            //$this->_model->listWhere[]='';
        
        
        
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    /**
     * Render
     */
    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign('Indikator',
            array(
            1 => array(
                'nev' => 'Cég',
                'link' => Rimo::$_config->DOMAIN . 'ceg/profil/'
            ),
            2 => array('nev' => 'Álláshirdetések')
        ));
        
        
        
        Rimo::$_site_frame->assign('PageName', 'Álláshirdetések');
        Rimo::$_site_frame->assign('site_title', 'Álláshirdetések');
        Rimo::$_site_frame->assign('site_description', 'Álláshirdetések');
        Rimo::$_site_frame->assign('site_keywords', 'Álláshirdetések');
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/ceg/view/site.allashirdetes_list.tpl'));
    }
}