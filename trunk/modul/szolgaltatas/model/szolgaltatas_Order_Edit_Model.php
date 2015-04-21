<?php
class Szolgaltatas_Order_Edit_Model extends Admin_Edit_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ceg_szolgaltatas_megrendeles';
    /**
     * Értékek, melyeket az itemekhez rendel.
     * @var array
     */
    public $_bindArray=array(
        'ceg_id' => 'SelCeg',
        'szolgaltatas_id' => 'SelSzolgaltatas',
        'statusz' => 'SelOrderStatusz',
        'ceg_szolgaltatas_megrendeles_aktiv' => 'ChkAktiv',
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
        $ceg = $this->addItem("SelCeg");
        $ceg->_select_value = $this->getSelectValues("ceg", "nev", " AND ceg_aktiv = 1","ORDER BY nev",false);
        
        $szolg = $this->addItem("SelSzolgaltatas");
        $szolg->_select_value = $this->getSelectValues("szolgaltatas", "nev", " AND szolgaltatas_aktiv = 1","ORDER BY nev",false);
        
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
    
    public function getName($companyID){
        $query = "SELECT nev FROM ceg WHERE ceg_id = ".(int)$companyID." LIMIT 1";
        $result = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $result['nev'];
    }
    
    public function getClients($orderID){
        try{
        $query = "SELECT ugyfelek_mappakbol, ugyfelek_jelentkezettek
                  FROM ceg_szolgaltatas_megrendeles
                    WHERE ceg_szolgaltatas_megrendeles_id = ".(int)$orderID." LIMIT 1
                ";
        
        $result = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        
        if(is_array(unserialize($result['ugyfelek_mappakbol']))){
            $result['ugyfelek_mappakbol'] = array_unique(unserialize($result['ugyfelek_mappakbol']));
        }else{
            $result['ugyfelek_mappakbol'] = array();
        }
        
        if(is_array(unserialize($result['ugyfelek_jelentkezettek']))){
            $result['ugyfelek_jelentkezettek'] = array_unique(unserialize($result['ugyfelek_jelentkezettek']));
        }else{
            $result['ugyfelek_jelentkezettek'] = array();
        }
        
        return array_unique($result);
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
    
    
    //depr
    public function getFolders($orderID){
        try{
        $query = "SELECT mappa_id
                  FROM szolgaltatas_megrendeles_ugyfelek
                    WHERE megrendeles_id = ".(int)$orderID."
                ";
        $result = $this->_DB->prepare($query)->query_select()->query_result_array();
        return $result;
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
    //depr
    public function getClientsByFolder($fID,$orderID){
        try{
        $query = "SELECT szmu.ugyfelek, cam.mappa_nev AS mappa
                    FROM szolgaltatas_megrendeles_ugyfelek szmu
                  INNER JOIN ceg_attr_mappa cam ON cam.ceg_attr_mappa_id = szmu.mappa_id
                  WHERE szmu.mappa_id = ".(int)$fID." AND szmu.megrendeles_id = ".(int)$orderID."
                  LIMIT 1
                ";
        
        
        $result = $this->_DB->prepare($query)->query_select()->query_fetch_array();
         
        $resultArray = array();
        $resultArray["mappanev"] = $result["mappa"];
        
        $uIDArr = unserialize($result["ugyfelek"]);
        
        
        foreach($uIDArr as $key=>$value){    
            $query = "SELECT ugyfel_id AS ugyfelID, CONCAT(vezeteknev, ' ', keresztnev) AS ugyfelNev FROM ugyfel WHERE ugyfel_id = ".(int)$value['ugyfelID'];
            try{
                $result = $this->_DB->prepare($query)->query_select()->query_result_array();
            }catch(Exception_MYSQL_Null_Rows $e){
                $result = array();
            }
            $resultArray["ugyfelek"][] = $result;
        }
        
        return $resultArray;
        
        
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
    
    
}