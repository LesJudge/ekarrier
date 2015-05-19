<?php
/**
 * @property MYSQL_DB $_DB Adatbázis.
 */
class User_Vegzettseg_SiteEdit_Model extends Page_Edit_Model
{
    protected $clientId;
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ugyfel_attr_vegzettseg';
    /**
     * Bindelt mezők.
     * @var array
     */
    public $_bindArray = array(
        'vegzettseg_id' => 'SelVegzettseg',
        'iskola' => 'TxtIskola',
        'kezdet' => 'YearKezdet',
        'veg' => 'YearVeg',
        'szak' => 'TxtSzak',
        'megnevezes' => 'TxtMegnevezes'
    );

    public function __addForm()
    {
        parent::__addForm();
        $yearVerify = array(
            'pattern' => '/^[0-9]{4}$/',
            'value' => true,
            'message' => 'Valós évszámot adjon meg!'
        );
        // Végzettség
        $vegzettseg = $this->addItem('SelVegzettseg');
        $vegzettseg->_verify['select'] = true;
        $vegzettseg->_select_value = $this->getSelectValues(
            'vegzettseg',
            'nev',
            ' AND vegzettseg_aktiv=1 AND vegzettseg_torolt=0',
            ' ORDER BY nev ASC',
            false,
            array('' => '--Kérem, válasszon!--')
        );
        // Iskola
        $iskola = $this->addItem('TxtIskola');
        //$iskola->_verify['string'] = true;
        // Kezdet
        $kezdet = $this->addItem('YearKezdet');
        $kezdet->_verify['pattern'] = $yearVerify;
        // Vég
        $veg = $this->addItem('YearVeg');
        $veg->_verify['pattern'] = $yearVerify;
        // Szak
        $szak = $this->addItem('TxtSzak');
        // Megnevezés.
        $megnevezes = $this->addItem('TxtMegnevezes');
    }
    /**
     * Eredeti __formValues() metódus felüldeklarálása.
     */
    public function __formValues()
    {
        $query = "SELECT " . Create::query_load_sets($this->_bindArray) . "
                  FROM {$this->_tableName}
                  WHERE {$this->_tableName}_id = " . (int)$this->modifyID . " AND
                        /*nyelv_id = " . Rimo::$_config->SITE_NYELV_ID . " AND*/
                        ugyfel_id = " . $this->clientId . "
                  LIMIT 1";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        foreach ($this->_bindArray as $field => $item) {
            $this->getItemObject($item, 'loadData')->_value = $data[$field];
        }
        if ($this->_params['YearKezdet']->_value == '0000') {
            $this->_params['YearKezdet']->_value = null;
        }
        if ($this->_params['YearVeg']->_value == '0000') {
            $this->_params['YearVeg']->_value = null;
        }
    }
    /**
     * Új rekord felvitele.
     */
    public function __insert($sets = '')
    {
        $userId = (int)UserLoginOut_Site_Controller::$_id;
        parent::__insert(
            ',ugyfel_id=' . $this->clientId . '     
            ,letrehozo_id = ' . $userId . '
            ,modosito_id = ' . $userId
        );
    }
    /**
     * Rekord módosítása.
     */
    public function __update($sets = '')
    {
        parent::__update(
            ',modosito_id = ' . (int)UserLoginOut_Site_Controller::$_id . '
            ,modositas_timestamp = NOW()
            ,modositas_szama = modositas_szama + 1'
        );
    }
    /**
     * Visszatér az ügyfél azonosítóval.
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }
    /**
     * Beállítja az ügyfél azonosítót.
     * @param int $clientId Ügyfél azonosító.
     */
    public function setClientId($clientId)
    {
        $this->clientId = (int)$clientId;
    }
}