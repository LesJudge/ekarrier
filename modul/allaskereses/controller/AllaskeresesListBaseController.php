<?php
/**
 * @property Smarty $_view
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
abstract class AllaskeresesBaseListController extends Admin_List
{
    public $_name = 'SiteAllaskereses';
    protected $_multiple_lang = false;
    public $view = null;
    public $seoKey = null;
    
    /**
     * Controller inicializálása.
     */
    public function __construct()
    {
        $this->__loadModel('_Show');
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->setModelWhereConditions();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    /**
     * Beállítja a model-re vonatkozó WHERE feltételeket.
     * @return void
     */
    abstract public function setModelWhereConditions();
    /**
     * Szokásos __show() metódus.
     */
    public function __show()
    {
        parent::__show();
        $lId = Rimo::$_config->SITE_NYELV_ID;
        $seo = seo_Site_Model::model()->getSeoItemByKey($this->seoKey, $lId);
        // Render
        Rimo::$_site_frame->assign('Indikator',
            array(
            1 => array(
                'nev' => $seo['seo_nev'],
            )
        ));
        //$this->_view->assign('FormMessage', 'FormMessage');
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content',
        $this->__generateForm('modul/allaskereses/view/' . $this->view));
    }
    /**
     * Szűrők beállítása.
     */
    public function onClick_Filter()
    {
        $this->setSelectFilterValue('FilterSector', 'allashirdetes.szektor_id');
        $this->setSelectFilterValue('FilterPosition', 'allashirdetes.pozicio_id');
        $this->setSelectFilterValue('FilterJob', 'allashirdetes.munkakor_id');
        $this->setSelectFilterValue('FilterCounty', 'allashirdetes.cim_megye_id');
        $city = $this->getItemValue('FilterCity');
        if (!empty($city)) {
            $this->setWhereInput("allashirdetes.varos LIKE '" . mysql_real_escape_string($city) . "'", 'FilterCity');
        } else {
            unset($_SESSION[$this->_name]['FilterCity']);
        }
    }
    /**
     * Beállítja a select filter értékét.
     * @param string $filter $_params-ban lévő filter neve.
     * @param string $field Adatbázisban lévő mező neve.
     * @return void
     */
    protected function setSelectFilterValue($filter, $field)
    {
        $value = (int)$this->getItemValue($filter);
        if ($value) {
            $this->setWhereInput($field . ' = ' . $value, $filter);
        } else {
            unset($_SESSION[$this->_name][$filter]);
        }
    }
}