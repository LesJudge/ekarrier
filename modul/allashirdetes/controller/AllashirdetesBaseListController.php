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
//require 'modul/ugyfellinkek/model/ugyfellinkek_Site_Model.php';
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
        $this->__addEvent('BtnAddLink', 'addLink');
        $this->__addEvent('BtnDeleteLink', 'deleteLink');
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
        
        try
        {
            $clientId = Rimo::getClientWebUser()->findByUserId(UserLoginOut_Site_Controller::$_id);
        }catch(Exception_MYSQL_Null_Rows $e){
        }
        
        $cegek = $this->getCegekByConditions();
        $this->_view->assign('cegek',$cegek);
        
        $tartalom = Rimo::__loadPublic('model', 'tartalom_Show', 'tartalom');
        $obj = $tartalom->getTartalomByID(34);
        $this->_view->assign("text",$obj[0]["tartalom_tartalom"]);
        
        
        
        Rimo::$_site_frame->assign('PageName', $obj[0]["tartalom_cim"]);
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
        //$this->setSelectFilterValue('FilterJob', 'allashirdetes_attr_munkakor.munkakor_id');
        
        
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
        
        $filterTevKor = $this->getItemValue('FilterTevKor');
        if (!empty($filterTevKor) && (int)$filterTevKor > 0) {
            $this->setWhereInput("mk2.munkakor_kategoria_id = " . (int)$filterTevKor, 'FilterTevKor');
        } else {
            unset($_SESSION[$this->_name]['FilterTevKor']);
        }
        
        $filterTevCsoport = $this->getItemValue('FilterTevCsoport');
        if (!empty($filterTevCsoport) && (int)$filterTevCsoport > 0) {
            $this->setWhereInput("(
                      SELECT munkakor_kategoria_id
                      FROM munkakor_kategoria mkin
                      WHERE mkin.baloldal < mk2.baloldal AND mkin.jobboldal > mk2.jobboldal AND mkin.szint = 1
                      LIMIT 1
                        ) = " . (int)$filterTevCsoport, 'FilterTevCsoport');
        } else {
            unset($_SESSION[$this->_name]['FilterTevCsoport']);
        }
        
        $letter = $this->getItemValue('FilterLetter');
        if (!empty($letter)) {
            $this->setWhereInput("munkakor.munkakor_nev LIKE '".mysql_real_escape_string($letter)."%'", 'FilterLetter');
        } else {
            unset($_SESSION[$this->_name]['FilterLetter']);
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
    /*
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
            echo $e->getMessage();
            $this->_view->assign('No_SelTetel', true);
            $this->_view->assign('FormError', 'Végzetes hiba lépett fel a művelet során!');
        }
    }
    */
    
   public function getCegekByConditions(){
       $filterTevKor = $this->getItemValue('FilterTevKor');
       $filterSector = $this->getItemValue('FilterSector');
       $filterLetter = $this->getItemValue('FilterLetter');
       $filterTevCsoport = $this->getItemValue('FilterTevCsoport');
       $filterCity = $this->getItemValue('FilterCity');
       $filterCounty = $this->getItemValue('FilterCounty');
       $wheres = array();
        
       if (!empty($filterTevKor) && (int)$filterTevKor > 0) {
            $wheres['tevkor'] = "ca.tevkor_id = ".(int)$filterTevKor;     
        }
        
        if (!empty($filterTevCsoport) && (int)$filterTevCsoport > 0) {
            $wheres['tevcsop'] = "(SELECT munkakor_kategoria_id
                                    FROM munkakor_kategoria mkin
                                    WHERE mkin.baloldal < mk.baloldal AND mkin.jobboldal > mk.jobboldal AND mkin.szint = 1 LIMIT 1
                                    ) =" .(int)$filterTevCsoport;     
        }
        
        if (!empty($filterSector) && $filterSector > 0) {
            $wheres['sector'] = "ca.szektor_id = ".(int)$filterSector;     
        }
        
        if (!empty($filterLetter)) {
            $wheres['letter'] = "c.nev LIKE '".mysql_real_escape_string($filterLetter)."%'";     
        }
        
        if (!empty($filterCity)) {
            $wheres['city'] = "(cv1.cim_varos_nev LIKE '".mysql_real_escape_string($filterCity)."' OR cv2.cim_varos_nev LIKE '".mysql_real_escape_string($filterCity)."')";     
        }
        
        if (!empty($filterCounty)) {
            $wheres['county'] = "(cm1.cim_megye_id = ".(int)$filterCounty." OR cm2.cim_megye_id = ".(int)$filterCounty.")";     
        }
        
        $whereString = implode(' AND ', $wheres);
        
        
        if(empty($whereString)){
            $whereString = "";
        }else{
            $whereString = "AND ".$whereString;
        }
        
        try{
            $query = "SELECT c.nev AS cegnev, c.ceg_id AS ID, c.link AS link
                      FROM ceg c
                      INNER JOIN ceg_adatok ca ON ca.ceg_id = c.ceg_id
                      LEFT JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = ca.tevkor_id
                      LEFT JOIN ceg_szekhely csz ON csz.ceg_id = c.ceg_id
                      LEFT JOIN ceg_telephely ct ON ct.ceg_id = c.ceg_id
                      LEFT JOIN cim_varos cv1 ON cv1.cim_varos_id = csz.cim_varos_id
                      LEFT JOIN cim_varos cv2 ON cv2.cim_varos_id = ct.cim_varos_id
                      LEFT JOIN cim_megye cm1 ON cm1.cim_megye_id = csz.cim_megye_id
                      LEFT JOIN cim_megye cm2 ON cm2.cim_megye_id = ct.cim_megye_id
                      WHERE c.ceg_aktiv = 1 AND c.ceg_torolt = 0 ".$whereString." GROUP BY c.ceg_id
                    ";
            return $this->_model->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();   
        }
        catch(Exception_MYSQL $e){
            return array();   
        }
   }
    
}