<?php

class Ceg_Telephely_SiteEdit_Model extends Page_Edit_Model
{
    /**
     * Cég azonosító.
     * @var int
     */
    protected $companyId;
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ceg_telephely';
    /**
     * bindArray
     * @var array
     */
    public $_bindArray = array(
        'cim_orszag_id' => 'SelOrszag',
        'cim_megye_id' => 'SelMegye',
        'cim_varos_id' => 'SelVaros',
        'cim_iranyitoszam_id' => 'SelIranyitoszam',
        'utca' => 'TxtUtca',
        'hazszam' => 'TxtHazszam',
        'ceg_telephely_aktiv' => 'ChkAktiv'
    );

    public function __addForm()
    {
        parent::__addForm();
        $ps = array('' => '--Kérem, válasszon!--');
        $addressFinder = new \AddressFinder($this->_DB);
        // Ország.
        $country = $this->addItem('SelOrszag');
        $country->_verify['select'] = true;
        $country->_select_value = $ps + $addressFinder->findCountries();
        // Megye.
        $county = $this->addItem('SelMegye');
        $county->_verify['select'] = true;
        $county->_select_value = $ps + $addressFinder->findCountiesByCountryId();
        // Város.
        $city = $this->addItem('SelVaros');
        $city->_verify['select'] = true;
        $city->_select_value = $ps + $addressFinder->findCitiesByCountryId();
        // Irányítószám
        $zipCode = $this->addItem('SelIranyitoszam');
        $zipCode->_verify['select'] = true;
        $zipCode->_select_value = $ps + $addressFinder->findZipCodesByCountryId();
        // Utca.
        $street = $this->addItem('TxtUtca');
        $street->_verify['string'] = true;
        // Házszám.
        $hn = $this->addItem('TxtHazszam');
        $hn->_verify['string'] = true;
        // Publikus
        $active = $this->addItem('ChkAktiv');
        $active->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->SITE_NYELV_ID];
    }

    public function __formValues()
    {
        $sql = "SELECT " . Create::query_load_sets($this->_bindArray) . " 
            FROM %s WHERE ceg_id = %d AND %s_id = %d AND %s_torolt = 0 LIMIT 1";
        $query = sprintf(
            $sql, 
            $this->_tableName, 
            $this->getCompanyId(), 
            $this->_tableName, 
            $this->modifyID, 
            $this->_tableName
        );
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        foreach ($this->_bindArray as $field => $item) {
            $this->getItemObject($item, 'loadData')->_value = $data[$field];
        }
    }

    public function __newData()
    {
        parent::__newData();
        $this->getItemObject('ChkAktiv')->_value = 1;
    }

    public function __insert()
    {
        $userId = (int)  UserLoginOut_Site_Controller::$_id;
        parent::__insert('
            ,ceg_id=' . $this->getCompanyId() . '
            ,letrehozo_id = ' . $userId . '
            ,modosito_id = ' . $userId
        );
    }

    public function __update()
    {
        parent::__update('
            ,ceg_id=' . $this->getCompanyId() . '
            ,modosito_id = ' . (int)UserLoginOut_Site_Controller::$_id . '
            ,modositas_timestamp = NOW()
            ,modositas_szama = modositas_szama + 1
        ');
    }

    public function getCompanyId()
    {
        return $this->companyId;
    }

    public function setCompanyId($companyId)
    {
        $this->companyId = (int)$companyId;
    }
}
