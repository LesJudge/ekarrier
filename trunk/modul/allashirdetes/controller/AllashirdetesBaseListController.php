<?php
/**
 * Álláshirdetés alap listázás controller. Erre a controllerre azért van szükség, mert megkülönböztetünk jelenleg is 
 * "élő" álláshirdetéseket, valamint lejárt, archívumban lévő álláshirdetéseket. Az absztrakt 
 * <b>setModelWhereConditions()</b> metódust kell definiálni az osztály használatba vételéhez. Itt adhatjuk meg, hogy 
 * milyen szűrési feltételek vonatkoznak az archív és az aktív álláshirdetésekre.
 * 
 * @property Allashirdetes_Site_List_Model $_model Listázó model.
 * @property Smarty $_view Site frame.
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
abstract class AllashirdetesBaseListController extends Admin_List
{
    /**
     * Controller neve a $_SESSION szuperglobálisban.
     * @var string
     */
    public $_name = 'SiteAllaskeresesBaseList';
    /**
     * Nyelvesített-e a controller.
     * @var boolean
     */
    protected $_multiple_lang = false;
    /**
     * SEO kulcs neve. Ez alapján alapján állítja be az oldal címét, leírását.
     * @var string
     */
    protected $seoKey = null;
    /**
     * Controller inicializálása.
     */
    public function __construct()
    {
        $this->__loadModel('_Site_List');
        parent::__construct(Rimo::$_config->SITE_NYELV_ID);
        $this->setModelWhereConditions();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    /**
     * Beállítja a model-re vonatkozó WHERE feltételeket.
     */
    abstract protected function setModelWhereConditions();
    /**
     * Renderelés előtt lefutó metódus.
     */
    abstract protected function beforeRender();
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
        Rimo::$_site_frame->assign('PageName', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_title', $seo['seo_nev']);
        Rimo::$_site_frame->assign('site_description', $seo['seo_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $seo['seo_meta_kulcsszo']);
        $this->beforeRender();
        Rimo::$_site_frame->assign(
                'Content',
                $this->__generateForm('modul/' . Rimo::$_config->APP_PATH . '/view/site.allashirdetes_list.tpl')
        );
    }
    /**
     * Szűrők beállítása.
     */
    public function onClick_Filter()
    {
        $this->setSelectFilterValue('FilterSector', 'allashirdetes.szektor_id');
        $this->setSelectFilterValue('FilterPosition', 'allashirdetes.pozicio_id');
        //$this->setSelectFilterValue('FilterJob', 'allashirdetes.munkakor_id');
        $this->setSelectFilterValue('FilterJob', 'allashirdetes_attr_munkakor.munkakor_id');
        $this->setSelectFilterValue('FilterCounty', 'allashirdetes.cim_megye_id');
        $city = $this->getItemValue('FilterCity');
        if (!empty($city)) {
            $this->setWhereInput("cv.cim_varos_nev LIKE '" . mysql_real_escape_string($city) . "'", 'FilterCity');
        } else {
            unset($_SESSION[$this->_name]['FilterCity']);
        }
        $filterEllenorzott = (int)$this->getItemValue('FilterEllenorzott');
        if ($filterEllenorzott == 0 || $filterEllenorzott == 1) {
            $this->setWhereInput('allashirdetes.ellenorzott = ' . (int)$filterEllenorzott, 'FilterEllenorzott');
        } else {
            unset($_SESSION[$this->_name]['FilterEllenorzott']);
        }
    }
    /**
     * Beállítja a select filter értékét.
     * @param string $filter $_params-ban lévő filter neve.
     * @param string $field Adatbázisban lévő mező neve.
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
    
    protected function getList()
    {
        try {
            $this->_view->assign('Fejlec', $this->_model->tableHeader);
            $this->getCount();
            $this->_model->limit = $this->vPaging->getSqlLimit();
            $this->vDataArray = $this->_model->__loadList();
        } catch (Exception_Mysql_Null_Rows $emnr) {
            $this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormInfo', 'Nincs megjeleníthető álláshirdetés!');
        } catch (Exception $e) {
            $this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormError', 'Végzetes hiba lépett fel a művelet során!');
        }
    }
}