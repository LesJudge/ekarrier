<?php
class Allashirdetes_Site_Edit_Model extends AllashirdetesBaseEditModel
{
    public function __construct()
    {
        parent::__construct();
        // $_bindArray kiegészítése.
        $this->_bindArray['egyedi'] = 'ChkEgyedi';
    }
    /**
     * Form elkészítése.
     */
    public function __addForm()
    {
        parent::__addForm();
        // Egyedi álláshirdetés-e.
        $chkUnique = $this->addItem('ChkEgyedi');
        $chkUnique->_verify['required'] = true;
        $chkUnique->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        // Hirdető
        $this->addItem('TxtHirdeto');
        // Cég kötelezőség törlése.
        unset($this->_params['SelCeg']->_verify['select']);
    }
    /**
     * Rekord ellenőrzés, nyelv_id "letiltása".
     * @param string $nyelv
     * @return boolean
     */
    public function verifyRow($nyelv = "")
    {
        return true;
    }
    /**
     * Rekord visszatöltés után lefutó metódus.
     * @return array
     */
    public function __editData()
    {
        $query = "SELECT num_megtekintve,
                         modositas_szama, 
                         letrehozas_timestamp, 
                         modositas_timestamp, 
                         u1.user_id AS letrehozo_id,
                         u1.user_fnev AS letrehozo_username,
                         CONCAT(u1.user_vnev, ' ', u1.user_knev) AS letrehozo_nev,
                         u2.user_id AS modosito_id,
                         u2.user_fnev AS modosito_username,
                         CONCAT(u2.user_vnev, ' ', u2.user_knev) AS modosito_nev,
                         allashirdetes_aktiv AS active
                  FROM {$this->_tableName}
                  LEFT JOIN user AS u1 ON letrehozo = u1.user_id
                  LEFT JOIN user AS u2 ON modosito = u2.user_id
                  WHERE allashirdetes_id = ". (int)$this->modifyID . "
                  LIMIT 1";
        try {
            $cityName = UserAddressFinder::model()->findCityById($this->_params['IdCity']->_value);
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            $cityName = '';
        }
        $extend = array('cityName' => $cityName);
        $data = array_merge(
            $this->_DB->prepare($query)->query_select()->query_fetch_array(),
            parent::__editData(),
            $extend
        );
        return $data;
    }
}