<?php
require 'page/admin/controller/admin.list.php';
require 'modul/allaskereses/controller/AllaskeresesListBaseController.php';
require 'modul/seo/model/seo_Site_Model.php';
/**
 * @property Smarty $_view Smarty
 */
class AllaskeresesArchivum_Site_Controller extends AllaskeresesBaseListController
{
    
    public $_name = 'SiteAllaskeresesArchivum';
    protected $_multiple_lang = false;
    public $view = 'site.allaskereses_archivum.tpl';
    public $seoKey = 'jobSearchArchive';
    
    /**
     * Beállítja a model-re vonatkozó WHERE feltételeket.
     * @return void
     */
    public function setModelWhereConditions()
    {
        $this->_model->listWhere[] = 'allashirdetes.lejarati_datum < \'' . date('Y-m-d') . '\'';
    }
}