<?php
require 'modul/seo/model/seo_Site_Model.php';
require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class TevekenysegikorStart_Site_Controller extends Page_Edit
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'TevekenysegikorStart';
    /**
     * SEO Site model.
     * @var seo_Site_Model
     */
    public $seo;
    
    public function __construct()
    {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $this->seo = new seo_Site_Model;
        $this->__loadModel('_Show');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addEvent('BtnAddLink', 'addLink');
        $this->__addEvent('BtnDeleteLink', 'deleteLink');
        $this->__run();
    }

    public function __show()
    {
        try
        {
        //Főoldali szöveg betöltése
        $tartalom = Rimo::__loadPublic('model', 'tartalom_Show', 'tartalom');
        $obj = $tartalom->getTartalomByID(20);
        $this->_view->assign("text",$obj[0]["tartalom_tartalom"]);
        //SEO
        $seo = $this->seo->findSeoItemByKey('fooldal');
        //Linkek
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        $links = ugyfellinkek_Site_Model::model()->findLinks($clientId);  
                        
                        $this->_view->assign("linkMode","on");
                        $this->_view->assign("addLinkOption","on");
                        $this->_view->assign("links",$links);
        // Render
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content', $this->__generateForm('modul/tevekenysegikor/view/site.tevekenysegikor_start.tpl'));
        }
        catch(Exception_MYSQL_Null_Rows $e)
        {
        
        }
    }
    
    public function onClick_addLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        ugyfellinkek_Site_Model::model()->validateSaveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."fooldal/");
        ugyfellinkek_Site_Model::model()->saveLink($clientId, $_REQUEST['linkName'], Rimo::$_config->DOMAIN."fooldal/");
    }
    
    public function onClick_deleteLink() {
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
        ugyfellinkek_Site_Model::model()->validateDeleteLink($clientId, $_REQUEST['delLink']);
        ugyfellinkek_Site_Model::model()->deleteLink($clientId, $_REQUEST['delLink']);
    }
}