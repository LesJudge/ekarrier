<?php
/**
 * @property MYSQL_DB $_DB Adatbázis.
 */
class Projekt_Edit_Model extends Admin_Edit_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'projekt';
    /**
     * Értékek, melyeket az itemekhez rendel.
     * @var array
     */
    public $_bindArray=array(
        'nev' => 'TxtNev',
        'projekt_aktiv' => 'ChkAktiv',
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
            'table' => 'projekt',
            'field' => 'nev',
            'modify' => $this->modifyID,
            'DB' => $this->_DB
        );
        // Ügyél megjegyzések.
        $this->addItem('TxtMegjegyzes');
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
                         projekt_aktiv AS active,
                         u1.user_id AS letrehozo_id,
                         CONCAT(u1.user_vnev, ' ', u1.user_knev) AS letrehozo_nev,
                         u1.user_fnev AS letrehozo_username, 
                         u2.user_id AS modosito_id,
                         CONCAT(u2.user_vnev, ' ', u2.user_knev) AS modosito_nev,
                         u2.user_fnev AS modosito_username
                  FROM {$this->_tableName}
                  LEFT JOIN user AS u1 ON letrehozo_id = u1.user_id
                  LEFT JOIN user AS u2 ON modosito_id = u2.user_id
                  WHERE projekt_id = " . (int)$this->modifyID . " LIMIT 1";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        $data['clients'] = $this->findClientsByProjectId($this->modifyID);
        return $data;
    }
    /**
     * Lekérdezi a projekthez tartozó ügyfeleket.
     * @param int $projectId Projekt azonosító.
     * @return array
     */
    public function findClientsByProjectId($projectId)
    {
        try {
            $query = "SELECT 
                uap.projekt_id, 
                uap.ugyfel_id, 
                uap.megjegyzes, 
                u.vezeteknev, 
                u.keresztnev, u.email, 
                us.user_fnev
                FROM ugyfel_attr_projekt uap 
                INNER JOIN ugyfel u ON uap.ugyfel_id = u.ugyfel_id 
                LEFT JOIN user_ugyfel uu ON u.ugyfel_id = uu.ugyfel_id 
                LEFT JOIN user us ON uu.user_id = us.user_id 
                WHERE uap.projekt_id = " . (int)$projectId . " ORDER BY u.vezeteknev ASC, u.keresztnev ASC";
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    /**
     * Menti az ügyfelekhez tartozó megjegyzéseket.
     * @param array $clients Ügyfél azonosítók és a hozzájuk tartozó megjegyzések. (id => megjegyzes)
     * @param int $projectId Projekt azonosítója.
     */
    public function addClientsByProjectId(array $clients, $projectId)
    {
        foreach ($clients as $clientId => $comment) {
            $this->addClient($projectId, $clientId, $comment);
        }
    }
    /**
     * Menti az ügyfelet a projekthez.
     * @param int $projectId Projekt azonosító.
     * @param int $clientId Ügyfél azonosító.
     * @param string $comment Megjegyzés.
     */
    public function addClient($projectId, $clientId, $comment = '')
    {
        $c = mysql_real_escape_string($comment);
        $query = "INSERT INTO ugyfel_attr_projekt 
                (projekt_id, ugyfel_id, megjegyzes) 
                VALUES 
                (" . (int)$projectId . ", " . (int)$clientId . ", '" . $c . "') 
                ON DUPLICATE KEY UPDATE megjegyzes = '" . $c . "'";
        $this->_DB->prepare($query)->query_execute();        
    }
    /**
     * Rekord módosítása.
     */
    public function __update()
    {
        $clients = $this->getItemValue('TxtMegjegyzes');
        if ($this->isValidClients($clients)) {
            $this->addClientsByProjectId($clients, $this->modifyID);
        }
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
        $clients = $this->getItemValue('TxtMegjegyzes');
        if ($this->isValidClients($clients)) {
            $this->addClientsByProjectId($clients, $this->insertID);
        }
    }
    /**
     * Megvizsgálja, hogy a paraméterül kapott eredményhalmaz alapján el lehet-e menteni az ügyfeleket.
     * @param array $clients
     * @return boolean
     */
    protected function isValidClients($clients)
    {
        return is_array($clients) && !empty($clients);
    }
}