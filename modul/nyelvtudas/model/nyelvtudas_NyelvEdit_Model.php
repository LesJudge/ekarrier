<?php
class Nyelvtudas_NyelvEdit_Model extends Admin_Edit_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'nyelvtudas_nyelv';
    /**
     * Értékek, melyeket az itemekhez rendel.
     * @var array
     */
    public $_bindArray=array(
        'nev' => 'TxtNev',
        'nyelvtudas_nyelv_aktiv' => 'ChkAktiv',
    );
    /**
     * Nyelv ellenőrzés felülírása, kikerülése. Erre azért van szükség, mert a táblában nincs nyelv_id mező.
     * @param string $nyelv
     * @return boolean
     */
    public function verifyRow($nyelv = "")
    {
        return true;
    }
    /**
     * Form elemek létrehozása.
     */
    public function __addForm()
    {
        parent::__addForm();
        // Név
        $name = $this->addItem('TxtNev');
        $name->_verify['string']=true;
        $name->_verify['string']=true;
        $name->_verify['unique']=array(
            'table' => 'nyelvtudas_nyelv',
            'field' => 'nev',
            'modify' => $this->modifyID,
            'DB' => $this->_DB
        );
    }
    /**
     * Egyéb adatok lekérdezése.
     * @return array
     */
    public function __editData()
    {
        parent::__editData();
        $query = "SELECT modositas_szama, 
                         letrehozas_timestamp, 
                         modositas_timestamp, 
                         nyelvtudas_nyelv_aktiv AS active,
                         u1.user_id AS letrehozo_id,
                         CONCAT(u1.user_vnev, ' ', u1.user_knev) AS letrehozo_nev,
                         u1.user_fnev AS letrehozo_username, 
                         u2.user_id AS modosito_id,
                         CONCAT(u2.user_vnev, ' ', u2.user_knev) AS modosito_nev,
                         u2.user_fnev AS modosito_username
                  FROM {$this->_tableName}
                  LEFT JOIN user AS u1 ON letrehozo_id = u1.user_id
                  LEFT JOIN user AS u2 ON modosito_id = u2.user_id
                  WHERE nyelvtudas_nyelv_id = " . (int)$this->modifyID . " LIMIT 1";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    /**
     * Rekord módosítása.
     */
    public function __update()
    {
        parent::__update(',modositas_timestamp = NOW()
                          ,modositas_szama = modositas_szama + 1
                          ,modosito_id = ' . UserLoginOut_Controller::$_id);
    }
    /**
     * Rekord létrehozása.
     */
    public function __insert()
    {
        $userId = UserLoginOut_Controller::$_id;
        parent::__insert(',letrehozo_id = ' . $userId . ', modosito_id = ' . $userId);
    }
}