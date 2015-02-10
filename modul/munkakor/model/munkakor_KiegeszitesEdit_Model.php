<?php
/**
 * @property MYSQL_DB $_DB Adatbázis.
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Munkakor_KiegeszitesEdit_Model extends Page_Edit_Model
{
    /**
     * Bindelt Item-ek
     * @var array
     */
    public $_bindArray = array();
    /**
     * A munkakör tartalmát vagy elvárásait szerkeszti-e éppen. True érték esetén az előbbit, ha pedig false, 
     * akkor az utóbbit.
     * @var boolean
     */
    protected $isContent;
    /**
     * A munkakör adatait tartalmazó tömb.
     * @var array
     */
    protected $jobData = array();
    
    /**
     * Inicializálja a modelt.
     * @param string $tableName A tábla neve.
     * @param boolean $isContent Tartalmat szerkesszen-e. Ha false, akkor az elvárásokat fogja.
     */
    public function init($tableName,$isContent)
    {
        $this->_tableName = $tableName;
        $this->isContent = $isContent;
        $this->bindArray();
    }
    /**
     * Szokásos __addForm metódus.
     */
    public function __addForm()
    {
        $content = $this->addItem('TxtTartalom');
        $content->_verify['string'] = true;
    }
    /**
     * Bindin'...
     */
    protected function bindArray()
    {
        $this->_bindArray[$this->_tableName.'_tartalom'] = 'TxtTartalom';
    }
    /**
     * Meggátolja a rekord "betöltését".
     * @return true
     */
    public function __formValues()
    {
        return true;
    }
    /**
     * Meggátolja a rekord módosítását.
     * @return true
     */
    public function __update()
    {
        return true;
    }
    /**
     * Rekord mentése.
     */
    public function __insert()
    {
        $jobData = $this->getJobData();
        parent::__insert(',munkakor_id = ' . (int)$jobData['munkakor_id']);
        $this->nyelvID = false;
    }
    /**
     * URL alapján lekérdezi a munkakört.
     * @param string $url A munkakör URL-je.
     * @param int $lId Nyelvi azonosító
     * @return array
     */
    public function getJobByUrl($url, $lId)
    {
        $query="SELECT m.munkakor_id,
                       m.munkakor_nev,
                       m.munkakor_link,
                       m.munkakor_leiras,
                       m.munkakor_meta_kulcsszo,
                       m.munkakor_tartalom,
                       m.munkakor_elvarasok
                FROM munkakor m
                WHERE m.munkakor_link = '".mysql_real_escape_string($url)."' AND
                      m.nyelv_id = " . (int)$lId . " AND
                      m.munkakor_aktiv = 1 AND
                      m.munkakor_torolt = 0
                LIMIT 1";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    /**
     * Visszatér a $jobData példányváltozó értékével.
     * @return array
     */
    public function getJobData()
    {
        return $this->jobData;
    }
    /**
     * A munkakör tartalmát szerkeszti-e éppen.
     * @return boolean
     */
    public function getIsContent()
    {
        return $this->isContent;
    }
    /**
     * Visszatér a megfelelő tartalommal (tartalom vagy elvárások), ha üres a $jobData, akkor pedig false-szal. 
     * @return array
     */
    public function getJobContent()
    {
        $jobData = $this->getJobData();
        if(count($jobData) > 0) {
            $attr = $this->getIsContent() ? 'munkakor_tartalom' : 'munkakor_elvarasok';
            return $jobData[$attr];
        } else {
            return false;
        }
    }
    /**
     * Beállítja a $jobData példányváltozó értékét.
     * @param array $jobData
     */
    public function setJobData(array $jobData)
    {
        $this->jobData=$jobData;
    }
}