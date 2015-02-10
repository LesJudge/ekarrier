<?php
require 'page/admin/controller/admin.list.php';
require 'modul/allaskereses/controller/AllaskeresesListBaseController.php';
require 'modul/seo/model/seo_Site_Model.php';
/**
 * @property Smarty $_view
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class AllaskeresesKereso_Site_Controller extends AllaskeresesBaseListController
{
    public $_name = 'SiteAllaskereses';
    protected $_multiple_lang = false;
    public $view = 'site.allaskereses_form.tpl';
    public $seoKey = 'jobSearch';
    
    /**
     * Beállítja a model-re vonatkozó WHERE feltételeket.
     * @return void
     */
    public function setModelWhereConditions()
    {
        $this->_model->listWhere[] = 'allashirdetes.lejarati_datum > \'' . date('Y-m-d') . '\'';
    }
}