<?php
/**
 * Cég SiteEdit Model.
 * 
 * @property MYSQL_DB $_DB Adatbázis.
 * 
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Ceg_SiteEdit_Model extends \AttachableUserModelAbstract
{
    /**
     * AddressFinder objektum.
     * @var \AddressFinder
     */
    protected $addressFinder;
    /**
     * UserHirlevelHelper objektum.
     * @var \UserHirlevelHelper
     */
    protected $userHirlevelHelper;
    /**
     * Konstruktor.
     */
    public function __construct()
    {
        parent::__construct();
        $helper = new \ModelEditHelper;
        $this->setAttacher(new \SiteCegEditInsert($this->_DB, $helper));
        $this->setAttached(new \SiteCegEditUpdate($this->_DB, $helper));
        $this->setFinder(new \SiteCegEditFinder($this->_DB));
        $this->userHirlevelHelper = new \UserHirlevelHelper($this->_DB);
        $this->addressFinder = new \AddressFinder($this->_DB);
    }
    /**
     * Szokásos __addForm() metódus.
     */
    public function __addForm()
    {
        parent::__addForm();
        if (!$this->modifyID) {
            $accept = $this->addItem('ChkElfogad');
            $accept->_verify['string'] = true;
        }
        $this->_params['ChkHirlevel']->_select_value = '';
        // Cégnév
        $cname = $this->addItem('TxtCegnev');
        $cname->_verify['string'] = true;
        // -- Kapcsolattartó adatok.
        // Kapcsolattartó telefon
        $ktotel = $this->addItem('TxtKtoTel');
        $ktotel->_verify['string'] = true;
        // Szektor.
        $sector = $this->addItem('SelSzektor');
        $sector->_verify['select'] = true;
        $sector->_select_value = $this->getSelectValues(
            'szektor',
            'szektor_nev',
            ' AND szektor_aktiv = 1 AND szektor_torolt = 0',
            ' ORDER BY szektor_nev ASC',
            true,
            array('' => '--Kérem, válasszon!--')
        );
        $ps = array('' => '--Kérem, válasszon!--');

        $tevkor = $this->addItem('SelTevkor');
        $tevkor->_verify['select'] = true;
        $tevkor->_select_value = array('' => '--Kérem, válasszon!--') + $this->tevekenysegiKoroketNekem();
        // -- Székhely adatok.
        // Ország.
        $hqCountry = $this->addItem('SelSzekhelyOrszag');
        $hqCountry->_select_value = $ps + $this->addressFinder->findCountries();
        // Megye.
        $hqCounty = $this->addItem('SelSzekhelyMegye');
        $hqCounty->_select_value = $ps + $this->addressFinder->findCountiesByCountryId();
        // Város.
        $hqCity = $this->addItem('SelSzekhelyVaros');
        $hqCity->_select_value = $ps + $this->addressFinder->findCitiesByCountryId();
        // Irányítószám.
        $hqZipCode = $this->addItem('SelSzekhelyIranyitoszam');
        $hqZipCode->_select_value = $ps + $this->addressFinder->findZipCodesByCountryId();
        // Utca
        $hqStreet = $this->addItem('TxtSzekhelyUtca');
        // Házszám.
        $hqHouseNumber = $this->addItem('TxtSzekhelyHazszam');
        // Cégjegyzékszám.
        $regNumber = $this->addItem('TxtCegjegyzekszam');
        // Adószám
        $taxNumber = $this->addItem('TxtAdoszam');
        // Munkakörök.
        $jobs = $this->addItem('SelMunkakorok');
        $jobs->_select_value = $this->getSelectValues(
            'munkakor', 
            'munkakor_nev', 
            ' AND munkakor_aktiv = 1 AND munkakor_torolt = 0', 
            ' ORDER BY munkakor_nev ASC', 
            true
        );
    }
    /**
     * Felhasználó és cég létrehozása.
     */
    public function __insert()
    {
        $this->insertID = $this->attacher->save($this->_params, null, null);
        $this->userHirlevelHelper->hirlevelUser($this->insertID, $this->_params);
        $this->_params['Password']->_value = $this->_params['Password2']->_value = null;
    }
    /**
     * Felhasználó és cég adatainak módosítása.
     */
    public function __update()
    {
        $this->modifyID = $this->attached->save($this->_params, $this->getUserId(), $this->getAttachedId());
        $this->userHirlevelHelper->hirlevelUser($this->modifyID, $this->_params);
        $this->_params['Password']->_value = $this->_params['Password2']->_value = null;
    }

    protected function tevekenysegiKoroketNekem()
    {
        $query = "SELECT job_id, main_name FROM munkakor_view GROUP BY main_name ORDER BY main_name ASC";
        $result = $this->_DB->prepare($query)->query_select();
        $tkorok = array();
        while ($tkor = $result->query_fetch_array()) {
            $tkorok[$tkor['job_id']] = $tkor['main_name'];
        }
        return $tkorok;
    }
}