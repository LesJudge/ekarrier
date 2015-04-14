<?php
/**
 * @property MYSQL_DB $_DB MYSQL_DB
 */
class UserAddressFinder extends Model
{
    /**
     * Irányítószám.
     * @var mixed
     */
    public $zipCode;
    /**
     * Konstruktor
     * @param mixed $zipCode => Irányítószám.
     */
    public function __construct($zipCode = false)
    {
        $this->addDB('MYSQL_DB');
        if ($zipCode) {
            $this->setZipCode($zipCode);
        }
    }
    /**
     * Példányosít egy modelt.
     * @param int $zipCode
     * @return \UserAddressFinder
     */
    public static function model($zipCode = false)
    {
        return new self($zipCode);
    }
    /**
     * Lekérdezi a hely adatait irányítószám alapján.
     * @param mixed $zipCode => Irányítószám.
     * @param boolean $match => Pontos egyezés.
     * @return mixed (array|false)
     */
    public function findLocationByZipCode($zipCode, $match = true)
    {
        try {
            $query = "SELECT i.cim_iranyitoszam_id,
                             v.cim_varos_id,
                             m.cim_megye_id,
                             i.cim_iranyitoszam_iranyitoszam AS iranyitoszam,
                             v.cim_varos_nev AS varos,
                             m.cim_megye_nev AS megye
                      FROM cim_iranyitoszam i
                      INNER JOIN cim_varos v ON v.cim_varos_id=i.cim_varos_id
                      INNER JOIN cim_megye m ON m.cim_megye_id=v.cim_megye_id ";
            if ($match) {
                $query.="WHERE i.cim_iranyitoszam_iranyitoszam='" . mysql_real_escape_string($zipCode) . "'";
            } else {
                $query.="WHERE i.cim_iranyitoszam_iranyitoszam LIKE '" . mysql_real_escape_string($zipCode) . "%'";
            }
            $dataObj = $this->_DB->prepare($query)->query_select();
            $locations = array();
            while ($data = $dataObj->query_fetch_array()) {
                $locations[$data['cim_varos_id']] = array(
                    'cim_iranyitoszam_id' => $data['cim_iranyitoszam_id'],
                    'cim_varos_id' => $data['cim_varos_id'],
                    'cim_megye_id' => $data['cim_megye_id'],
                    'iranyitoszam' => $data['iranyitoszam'],
                    'varos' => $data['varos'],
                    'megye' => $data['megye']
                );
            }
            return $locations;
        } catch (Exception_MYSQL_Null_Rows $e) {
            return false;
        }
    }
    /**
     * Irányítószám azonosító alapján lekérdezi a település adatait.
     * @param int $zipCodeId => Irányítószám azonosítója.
     * @return mixed (array|false)
     */
    public function findLocationByZipCodeId($zipCodeId)
    {
        try {
            /*$query = "SELECT i.cim_iranyitoszam_id,
                             v.cim_varos_id,
                             m.cim_megye_id,
                             i.cim_iranyitoszam_iranyitoszam AS iranyitoszam,
                             v.cim_varos_nev AS varos,
                             m.cim_megye_nev AS megye
                      FROM cim_iranyitoszam i
                      INNER JOIN cim_varos v ON v.cim_varos_id=i.cim_varos_id
                      INNER JOIN cim_megye m ON m.cim_megye_id=v.cim_megye_id
                      WHERE i.cim_iranyitoszam_id=" . (int) $zipCodeId;
            
            */
            $query = "SELECT i.cim_iranyitoszam_id,
                             v.cim_varos_id,
                             m.cim_megye_id,
                             i.iranyitoszam AS iranyitoszam,
                             v.cim_varos_nev AS varos,
                             m.cim_megye_nev AS megye
                      FROM cim_iranyitoszam i
                      INNER JOIN cim_varos v ON v.cim_varos_id=i.cim_varos_id
                      INNER JOIN cim_megye m ON m.cim_megye_id=v.cim_megye_id
                      WHERE i.cim_iranyitoszam_id=" . (int) $zipCodeId;        
                    
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        } catch (Exception_MYSQL_Null_Rows $e) {
            return false;
        }
    }
    /**
     * Feldolgozza az egy dimenziós eredményhalmazt (kulcs-érték párokat készít belülők id-érték alapján).
     * @param \MYSQL_Query $queryResult Eredményhalmaz.
     * @param string $id Azonosító mező neve.
     * @param string $value Érték mező neve.
     * @return array
     */
    private function processSingleResult(\MYSQL_Query $queryResult, $id, $value)
    {
        $result = array();
        while ($data = $queryResult->query_fetch_array()) {
            $result[$data[$id]] = $data[$value];
        }
        return $result;
    }
    /**
     * Lekérdezi az összes irányítószámot.
     * @return array
     */
    public function findZipCodes()
    {
        try {
            $query = "SELECT cim_iranyitoszam_id, cim_iranyitoszam_iranyitoszam FROM cim_iranyitoszam";
            return $this->processSingleResult(
                $this->_DB->prepare($query)->query_select(),
                'cim_iranyitoszam_id',
                'cim_iranyitoszam_iranyitoszam'
            );
        } catch (Exception_MYSQL_Null_Rows $ex) {
            return array();
        }
    }
    /**
     * Lekérdezi az összes megyét.
     * @return array
     */
    public function findCounties()
    {
        try {
            $query = "SELECT * FROM cim_megye ORDER BY cim_megye_nev ASC";
            return $this->processSingleResult(
                $this->_DB->prepare($query)->query_select(),
                'cim_megye_id',
                'cim_megye_nev'
            );
        } catch (Exception_MYSQL_Null_Rows $ex) {
            return array();
        }
    }
    /**
     * Lekérdezi az összes várost.
     * @return array
     */
    public function findCities()
    {
        try {
            $query = "SELECT cim_varos_id, cim_varos_nev FROM cim_varos ORDER BY cim_varos_nev ASC";
            return $this->processSingleResult(
                $this->_DB->prepare($query)->query_select(),
                'cim_varos_id',
                'cim_varos_nev'
            );
        } catch (Exception_MYSQL_Null_Rows $ex) {
            return array();
        }
    }
    /**
     * Lekérdezi a város nevét város azonosító alapján.
     * @param int $cityId Város azonosító.
     * @return string
     * @throws Exception_MYSQL_Null_Rows
     */
    public function findCityById($cityId)
    {
        $query = "SELECT cim_varos_nev FROM cim_varos WHERE cim_varos_id = " . (int)$cityId. " LIMIT 1";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array('cim_varos_nev');
    }
    /**
     * Lekérdezi a hely adatait irányítószám alapján ($this->zipCode).
     * @return mixed (array|false)
     */
    public function findLocation()
    {
        return $this->findLocationByZipCode($this->getZipCode());
    }
    /**
     * Visszatér az irányítószámmal.
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
    /**
     * Beállítja az irányítószámot.
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }
}
