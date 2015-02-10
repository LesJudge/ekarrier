<?php
require 'modul/seo/model/seo_Site_Model.php';
/**
 * @property Munkakor_Kereso_Model $_model
 * @property Smarty $_view
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class MunkakorKereso_Site_Controller extends RimoController
{
    /**
     * Controller neve a $_SESSION szuperglobálisban.
     * @var string
     */
    public $_name = 'SiteMunkakorKereso';
    /**
     * SEO Site model.
     * @var seo_Site_Model
     */
    public $seo;
    /**
     * Run controller.
     */
    public function __construct()
    {   
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->__loadModel('_Kereso');
        $this->seo = new seo_Site_Model;
        $this->__addParams($this->_model->_params);
        $this->__addEvent("BtnSearch","search");
        $this->_action_type=$_REQUEST;
        $this->__run();
    }
    
      
    /**
     * Render.
     */
    public function __show()
    {
        try {
            $seo = $this->seo->findSeoItemByKey('munkakorKereso'); // Job Search SEO
            // Kategóriák lekérdezése.
            $categories = $this->_model->getCategories();
            
            
            $this->_view->assign('subCategories', $subCategories);
            $this->_view->assign('categories', $categories);
            $this->_view->assign('tooltips', Rimo::$_config->tooltips);
            //
            Rimo::$_site_frame->assign('PageName', false);
            Rimo::$_site_frame->assign('Indikator', array());
            Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
            Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
            Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
            Rimo::$_site_frame->assign(
                'Content',
                $this->__generateForm('modul/munkakor/view/site.munkakor_kereso.tpl')
            );
            
            
        } catch (Exception $e) {
            throw new Exception_404; // Bármilyen hibánál dobjon 404-et.
        }
    }
    
    
}
