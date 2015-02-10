<?php
require 'page/all/controller/page.list.php';
require 'modul/seo/model/seo_Site_Model.php';
/**
 * @property Allashirdetes_Site_Megjelolt_List_Model $_model Listázás model.
 * @property Smarty $_view Smarty.
 */
class AllashirdetesMegjelolt_Site_Controller extends Page_List
{
    /**
     * Controller neve a $_SESSION szuperglobálisban.
     * @var string
     */
    public $_name = 'SiteAllashirdetesMegjelolt';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;
    /**
     * SEO Site model.
     * @var seo_Site_Model
     */
    public $seo;
    
    public function __construct()
    {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->__loadModel('_Site_Megjelolt_List');
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->_model->listWhere['user_id'] = 'user_attr_allashirdetes_megjelolt.user_id = ' . UserLoginOut_Site_Controller::$_id;
        $this->seo = new seo_Site_Model;
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show()
    {
        parent::__show();
        $seo = $this->seo->findSeoItemByKey('allashirdetesMegjelolt');
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        Rimo::$_site_frame->assign(
            'Content',
            $this->__generateForm('modul/' . Rimo::$_config->APP_PATH . '/view/site.allashirdetes_megjelolt_list.tpl')
        );
    }
    
    protected function getList() {
        try {
            $this->getCount();
            $this->_model->limit = $this->vPaging->getSqlLimit();
            $this->vDataArray = $this->_model->__loadList();
        } catch (Exception_Mysql_Null_Rows $e) {
            $this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormInfo', 'Ön nem jelölt meg egyetlen álláshirdetést sem!');
        } catch (Exception $e) {
            $this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormError', 'Végzetes hiba lépett fel a művelet során!');
        }
    }
}