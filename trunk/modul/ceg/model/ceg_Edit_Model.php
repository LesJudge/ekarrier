<?php
class Ceg_Edit_Model extends Admin_Edit_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ceg';
    /**
     * Bindarray.
     * @var string
     */
    public $_bindArray = array(
        'nev' => 'TxtNev',
        'link' => 'TxtLink',
        'leiras' => 'TxtLeiras',
        'meta_kulcsszo' => 'TxtKulcsszo',
        'tartalom' => 'TxtTartalom',
        'ceg_aktiv' => 'ChkAktiv'
    );
    /**
     *
     * @var \AddressFinder
     */
    protected $addressFinder;
    /**
     *
     * @var \SiteCegEditFinder
     */
    protected $siteCegEditFinder;
    
    public function __construct()
    {
        parent::__construct();
        $this->addressFinder = new \AddressFinder($this->_DB);
        $this->siteCegEditFinder = new \SiteCegEditFinder($this->_DB);
    }
    
    public function verifyRow($nyelv = "")
    {
        return true;
    }
        
    public function __addForm()
    {
        parent::__addForm();
        // Név
        $this->addItem('TxtNev')->_verify['string'] = true;
        // Link
        $link = $this->addItem('TxtLink');
        $link->_verify['string'] = true;
        $link->_verify['unique'] = array(
            'table' => 'ceg',
            'field' => 'link',
            'modify' => $this->modifyID,
            'DB' => $this->_DB
        );
        // Leírás
        $this->addItem('TxtLeiras')->_verify['string'] = true;
        // Kulcsszó
        $this->addItem('TxtKulcsszo')->_verify['required'] = true;
        // Tartalom
        $this->addItem('TxtTartalom')->_verify['string'] = true;
        // Cégjegyzék szám
        $this->addItem('TxtCegjegyzekszam');
        // Adószám
        $this->addItem('TxtAdoszam');
        $ps = array('' => '--Kérem, válasszon!--');
        // Szektor
        $sector = $this->addItem('SelSzektor');
        $sector->_verify['select'] = true;
        $sector->_select_value = $ps + $this->getSelectValues(
            'szektor',
            'szektor_nev',
            ' AND szektor_aktiv = 1 AND szektor_torolt = 0 ',
            ' ORDER BY szektor_nev ASC',
            true,
            $ps
        );
        // -- Székhely adatok.
        // Ország
        $country = $this->addItem('SelSzekhelyOrszag');
        $country->_verify['select'] = true;
        $country->_select_value = $ps + $this->addressFinder->findCountries();
        // Megye
        $county = $this->addItem('SelSzekhelyMegye');
        $county->_verify['select'] = true;
        $county->_select_value = $ps + $this->addressFinder->findCountiesByCountryId();
        // Város
        $city = $this->addItem('SelSzekhelyVaros');
        $city->_verify['select'] = true;
        $city->_select_value = $ps + $this->addressFinder->findCitiesByCountryId();
        // Irányítószám
        $zipCode = $this->addItem('SelSzekhelyIranyitoszam');
        $zipCode->_verify['select'] = true;
        $zipCode->_select_value = $ps + $this->addressFinder->findZipCodesByCountryId();
        // Utca
        $street = $this->addItem('TxtSzekhelyUtca');
        $street->_verify['string'] = true;
        // Házszám
        $hn = $this->addItem('TxtSzekhelyHazszam');
        $hn->_verify['string'] = true;
        // -- Kapcsolattartó adatok.
        // Vezetéknév
        $lastname = $this->addItem('TxtVnev');
        $lastname->_verify['string'] = true;
        // Keresztnév
        $firstname = $this->addItem('TxtKnev');
        $firstname->_verify['string'] = true;
        // E-mail cím
        $email = $this->addItem('TxtEmail');
        $email->_verify['string'] = true;
        $email->_verify['email'] = true;
        // Telefonszám
        $phone = $this->addItem('TxtKtoTel');
        $phone->_verify['string'] = true;
    }
    /**
     * Megtekintések számának törlése.
     * @return void
     */
    public function deleteMegtekintes()
    {
        $query = "UPDATE {$this->_tableName} SET megtekintve = 0 WHERE ceg_id = " . (int)$this->modifyID . " LIMIT 1";
        $this->_DB->prepare($query)->query_update();
    }
    /**
     * Link átalakítása.
     * @return void
     */
    public function removeAccentsFromLink()
    {
        $this->_params['TxtLink']->_value = Create::remove_accents($this->_params['TxtLink']->_value);
    }
    /**
     * Elválasztó törlése a linkből.
     * @return void
     */
    public function removeDelimitterFromKulcsszo()
    {
        while (strpos($this->_params['TxtKulcsszo']->_value, ',,') !== false) {
            $this->_params['TxtKulcsszo']->_value = str_replace(',,', ',', $this->_params['TxtKulcsszo']->_value);
        }
    }
    
    public function __formValues()
    {
        parent::__formValues();
        $this->siteCegEditFinder->findAndSet($this->modifyID, $this->_params);
    }
    /**
     * 
     * @return array
     */
    public function __editData()
    {
        parent::__editData();
        $query = "SELECT megtekintve, modositas_szama, letrehozas_timestamp, modositas_timestamp, 
                  u1.user_id AS letrehozo_id, 
                  u1.user_vnev AS letrehozo_vnev, 
                  u1.user_knev AS letrehozo_knev,
                  u1.user_fnev AS letrehozo_fnev, 
                  u2.user_id AS modosito_id, 
                  u2.user_vnev AS modosito_vnev, 
                  u2.user_knev AS modosito_knev, 
                  u2.user_fnev AS modosito_fnev
                  FROM {$this->_tableName}
                  LEFT JOIN user AS u1 ON letrehozo_id = u1.user_id
                  LEFT JOIN user AS u2 ON modosito_id = u2.user_id
                  WHERE ceg_id = " . (int)$this->modifyID . " LIMIT 1";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    /**
     * Cég módosítása.
     */
    public function __update()
    {
        $siteCegEditUpdate = new \SiteCegEditUpdate($this->_DB, new \ModelEditHelper);
        $siteCegEditUpdate->updateCompanyData(
            $this->modifyID,
            $this->getItemValue('SelSzektor'),
            $this->getItemValue('TxtCegjegyzekszam'),
            $this->getItemValue('TxtAdoszam'),
            UserLoginOut_Admin_Controller::$_id
        );
        $siteCegEditUpdate->updateContact(
            $this->modifyID, 
            $this->getItemValue('TxtVnev'), 
            $this->getItemValue('TxtKnev'), 
            $this->getItemValue('TxtEmail'), 
            $this->getItemValue('TxtKtoTel')
        );
        $siteCegEditUpdate->updateHeadquarters(
            $this->modifyID, 
            $this->getItemValue('SelSzekhelyOrszag'), 
            $this->getItemValue('SelSzekhelyMegye'),
            $this->getItemValue('SelSzekhelyVaros'),
            $this->getItemValue('SelSzekhelyIranyitoszam'),
            $this->getItemValue('TxtSzekhelyUtca'),
            $this->getItemValue('TxtSzekhelyHazszam'),
            UserLoginOut_Admin_Controller::$_id
        );
        parent::__update(',modositas_timestamp=now()
                                              ,modositas_szama=modositas_szama+1
                                              ,modosito_id=' . UserLoginOut_Controller::$_id
        );
    }
    /**
     * Cég létrehozása.
     */
    public function __insert()
    {
        $userId = (int)UserLoginOut_Admin_Controller::$_id;
        parent::__insert(',letrehozo_id = ' . $userId . ', modosito_id = ' . $userId);
        $siteCegEditInsert = new \SiteCegEditInsert($this->_DB, new \ModelEditHelper);
        $siteCegEditInsert->insertCompanyData(
            $this->insertID,
            $this->getItemValue('SelSzektor'),
            $this->getItemValue('TxtCegjegyzekszam'),
            $this->getItemValue('TxtAdoszam'),
            $userId
        );
        $siteCegEditInsert->insertContact(
            $this->insertID, 
            $this->getItemValue('TxtVnev'), 
            $this->getItemValue('TxtKnev'), 
            $this->getItemValue('TxtEmail'), 
            $this->getItemValue('TxtKtoTel')        
        );
        $siteCegEditInsert->insertHeadquarters(
            $this->insertID, 
            $this->getItemValue('SelSzekhelyOrszag'), 
            $this->getItemValue('SelSzekhelyMegye'),
            $this->getItemValue('SelSzekhelyVaros'),
            $this->getItemValue('SelSzekhelyIranyitoszam'),
            $this->getItemValue('TxtSzekhelyUtca'),
            $this->getItemValue('TxtSzekhelyHazszam'),
            $userId
        );
    }
    /**
     * Cég állapot.
     * @return string
     */
    public function cegAllapot()
    {
        if ($this->_params["ChkAktiv"]->_value != 1) {
            return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A cég nem publikus!'></span>";
        }
        return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
    }
}