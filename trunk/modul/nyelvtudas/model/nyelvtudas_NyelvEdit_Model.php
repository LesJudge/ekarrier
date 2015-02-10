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
        'nyelvtudas_nyelv_nev' => 'TxtNev',
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
            'field' => 'nyelvtudas_nyelv_nev',
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
        $query = "SELECT nyelvtudas_nyelv_modositas_szama, 
                         nyelvtudas_nyelv_letrehozas_datum, 
                         nyelvtudas_nyelv_modositas_datum, 
                         nyelvtudas_nyelv_aktiv AS active,
                         u1.user_id AS nyelvtudas_nyelv_letrehozo,
                         CONCAT(u1.user_vnev, ' ', u1.user_knev) AS letrehozo_nev,
                         u1.user_fnev AS letrehozo_username, 
                         u2.user_id AS nyelvtudas_nyelv_modosito,
                         CONCAT(u2.user_vnev, ' ', u2.user_knev) AS modosito_nev,
                         u2.user_fnev AS modosito_username
                  FROM {$this->_tableName}
                  LEFT JOIN user AS u1 ON nyelvtudas_nyelv_letrehozo = u1.user_id
                  LEFT JOIN user AS u2 ON nyelvtudas_nyelv_modosito = u2.user_id
                  WHERE nyelvtudas_nyelv_id = " . (int)$this->modifyID . " LIMIT 1";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    /**
     * Rekord módosítása.
     */
    public function __update()
    {
        parent::__update(',nyelvtudas_nyelv_modositas_datum = NOW()
                          ,nyelvtudas_nyelv_modositas_szama = nyelvtudas_nyelv_modositas_szama + 1
                          ,nyelvtudas_nyelv_modosito = ' . UserLoginOut_Controller::$_id);
    }
    /**
     * Rekord létrehozása.
     */
    public function __insert()
    {
        $userId = UserLoginOut_Controller::$_id;
        parent::__insert(',nyelvtudas_nyelv_letrehozo = ' . $userId . ', nyelvtudas_nyelv_modosito = ' . $userId);
    }
}