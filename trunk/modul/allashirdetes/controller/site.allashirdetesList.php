<?php
//require 'page/admin/controller/admin.list.php';
require 'modul/allashirdetes/controller/AllashirdetesBaseListController.php';
require 'modul/seo/model/seo_Site_Model.php';
/**
 * Aktuális álláshirdetéseket megjelenítő controller.
 * 
 * @property Allashirdetes_Site_List_Model $_model Listázó model.
 * @property Smarty $_view Site frame.
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class AllashirdetesList_Site_Controller extends AllashirdetesBaseListController
{
    /**
     * Controller neve a $_SESSION szuperglobálisban.
     * @var string
     */
    public $_name = 'SiteAllashirdetesList';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;
    /**
     * SEO kulcs neve. Ez alapján alapján állítja be az oldal címét, leírását.
     * @var string
     */
    protected $seoKey = 'jobSearch';
    /**
     * Beállítja a model-re vonatkozó WHERE feltételeket.
     */
    protected function setModelWhereConditions()
    {
        $this->_model->listWhere[] = "allashirdetes.lejarati_datum > '" . mysql_real_escape_string(date('Y-m-d')) . "'";
    }
    /**
     * Renderelés előtt lefutó metódus.
     */
    protected function beforeRender()
    {
        $this->_view->assign('isArchive', false);
    }
}