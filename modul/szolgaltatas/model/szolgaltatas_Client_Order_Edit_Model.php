<?php
class Szolgaltatas_Client_Order_Edit_Model extends Admin_Edit_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ugyfel_szolgaltatas_megrendeles';
    /**
     * Értékek, melyeket az itemekhez rendel.
     * @var array
     */
    public $_bindArray=array(
        'ugyfel_id' => 'SelUgyfel',
        'szolgaltatas_id' => 'SelSzolgaltatas',
        'statusz' => 'SelOrderStatusz',
        'ugyfel_szolgaltatas_megrendeles_aktiv' => 'ChkAktiv',
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
        $ugyfel = $this->addItem("SelUgyfel");
        $ugyfel->_select_value = $this->getSelectValues("ugyfel", "nev", " AND ceg_aktiv = 1","ORDER BY nev",false);
        
        $szolg = $this->addItem("SelSzolgaltatas");
        $szolg->_select_value = $this->getSelectValues("szolgaltatas", "nev", " AND szolgaltatas_tipus = 'ugyfel' AND szolgaltatas_aktiv = 1","ORDER BY nev",false);
        
        $statusz = $this->addItem("SelOrderStatusz");
        $statusz->_select_value = array('0'=>'Függőben','1'=>'Feldolgozva');
        
    }
    /**
     * Egyéb adatok lekérdezése.
     * @return array
     */
    public function __editData()
    {
        parent::__editData();
      /*  $query = "SELECT modositas_szama, 
                         letrehozas_timestamp, 
                         modositas_timestamp, 
                         szolgaltatas_aktiv AS active,
                         u1.user_id AS letrehozo_id,
                         CONCAT(u1.user_vnev, ' ', u1.user_knev) AS letrehozo_nev,
                         u1.user_fnev AS letrehozo_username, 
                         u2.user_id AS modosito_id,
                         CONCAT(u2.user_vnev, ' ', u2.user_knev) AS modosito_nev,
                         u2.user_fnev AS modosito_username
                  FROM {$this->_tableName}
                  LEFT JOIN user AS u1 ON letrehozo_id = u1.user_id
                  LEFT JOIN user AS u2 ON modosito_id = u2.user_id
                  WHERE szolgaltatas_id = " . (int)$this->modifyID . " LIMIT 1";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;*/
    }
    /**
     * Rekord módosítása.
     */
    public function __update()
    {
        parent::__update(',modositas_datum = NOW()
                          ,modosito = ' . UserLoginOut_Controller::$_id);
    }
    /**
     * Rekord létrehozása.
     */
    public function __insert()
    {
        //$userId = UserLoginOut_Controller::$_id;
        //parent::__insert(',letrehozo_id = ' . $userId . ', modosito_id = ' . $userId);
    }
    
    public function getName($clientID){
        $query = "SELECT CONCAT(vezeteknev, ' ',keresztnev) AS nev FROM ugyfel WHERE ugyfel_id = ".(int)$clientID." LIMIT 1";
        $result = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $result['nev'];
    }
    
}