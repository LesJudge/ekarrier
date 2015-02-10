<?php
require 'modul/seo/model/seo_Site_Model.php';
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class MunkakorStart_Site_Controller extends RimoController
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'MunkakorStart';
    /**
     * SEO Site model.
     * @var seo_Site_Model
     */
    public $seo;
    
    public function __construct()
    {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->seo = new seo_Site_Model;
        $this->__run();
    }

    public function __show()
    {
        $tartalom = Rimo::__loadPublic('model', 'tartalom_Show', 'tartalom');
        
        $obj = $tartalom->getTartalomByID(20);
        
        $this->_view->assign("text",$obj[0]["tartalom_tartalom"]);
        
        $seo = $this->seo->findSeoItemByKey('jobs');
        // Render
        Rimo::$_site_frame->assign('PageName', false);
        Rimo::$_site_frame->assign('Indikator', false);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/munkakor/view/site.munkakor_start.tpl'));
    }
}