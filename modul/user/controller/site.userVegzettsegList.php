<?php
require 'page/all/controller/page.list.php';
require 'modul/seo/model/seo_Site_Model.php';
/**
 * @property User_Vegzettseg_SiteList_Model $_model
 * @property Smarty $_view
 */
class UserVegzettsegList_Site_Controller extends Page_List
{
    /**
     * Controller neve a $_SESSION szuperglobálisban.
     * @var string
     */
    public $_name = 'VegzettsegList';
    /**
     * Nyelvesített controller-e.
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
        $this->__loadModel('_Vegzettseg_SiteList');
        $this->_model->listWhere['ugyfel_id'] = 'ugyfel_attr_vegzettseg.ugyfel_id = ' . $clientId;
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->seo = new seo_Site_Model;
        $this->__addParams($this->_model->_params);
        $this->__run();
    }

    public function __show()
    {
        parent::__show();
        $seo = $this->seo->findSeoItemByKey('myQualifications');
        Rimo::$_site_frame->assign('Indikator', array(
            1 => array(
                'nev' => 'Profil',
                'link' => Rimo::$_config->DOMAIN . 'profil/'
            ),
            2 => array('nev' => $seo['seo_nev'])
        ));
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/user/view/site.user_vegzettseg_list.tpl'));
    }
    
    protected function getList()
    {
        try {
            $this->getCount();
            $this->_model->limit = $this->vPaging->getSqlLimit();
            $this->vDataArray = $this->_model->__loadList();
        } catch (Exception_Mysql_Null_Rows $e) {
            $this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormInfo', 'Nincs megjeleníthető végzettség!');
        } catch (Exception $e) {
            $this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormError', 'Végzetes hiba a művelet során!');
        }
    }
}