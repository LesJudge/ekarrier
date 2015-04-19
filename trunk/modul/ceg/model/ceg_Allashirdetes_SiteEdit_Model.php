<?php
/**
 * Site álláshirdetés edit model
 * 
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Ceg_Allashirdetes_SiteEdit_Model extends AllashirdetesBaseEditModel
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'allashirdetes';
    /**
     * Cég azonosító.
     * @var int
     */
    protected $companyId;
    /**
     * Form generálás.
     */
    public function __addForm()
    {
        parent::__addForm();
        // Validációs szabályok felülírása.
        $this->getItemObject('ChkEgyedi')->_verify = array();
        $this->getItemObject('SelCeg')->_verify = array();
        $this->getItemObject('ChkEllenorzott')->_verify = array();
    }
    /**
     * Rekord "visszatöltése".
     * @return void
     */
    public function __formValues()
    {
        $data = $this->findJobAd();
        // Item értékek.
        foreach ($this->_bindArray as $field => $item) {
            $this->getItemObject($item, "loadData")->_value = $data[$field];
        }
    }
    
    protected function findJobAd()
    {
        // SQL
        $sql = "SELECT " . Create::query_load_sets($this->_bindArray) . " FROM %s 
            WHERE %s_id = %d AND ceg_id = %d LIMIT 1";
        // Lekérdezés végrehajtása.
        return $this->_DB->prepare(
            sprintf($sql, $this->_tableName, $this->_tableName, $this->modifyID, $this->getCompanyId())
        )->query_select()->query_fetch_array();
    }
    /**
     * Álláshirdetés mentése.
     * @param string $sets Sets
     */
    public function __insert($sets = '')
    {
        $this->getItemObject('TxtLink')->_value = Create::remove_accents($this->getItemValue('TxtNev'));
        $this->getItemObject('SelCeg')->_value = $this->companyId;
        $this->getItemObject('ChkEgyedi')->_value = 0;
        parent::__insert($sets);
    }
    /**
     * Álláshirdetés módosítása.
     * @param string $sets Sets
     */
    public function __update($sets = '')
    {
        $data = $this->findJobAd();
        $this->getItemObject('ChkEgyedi')->_value = $data['egyedi'];
        $this->getItemObject('SelCeg')->_value = $data['ceg_id'];
        $this->getItemObject('TxtLink')->_value = $data['link'];
        parent::__update($sets);
    }
    /**
     * Visszatér a cég azonosítóval.
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }
    /**
     * Beállítja a cég azonosítót.
     * @param int $companyId Cég azonosító.
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = (int)$companyId;
    }
    
    protected function saveMunkakor($jobId, $munkakorId)
    {
        if ((int)$munkakorId > 0) {
            parent::saveMunkakor($jobId, $munkakorId);
        } else {
            throw new \InvalidArgumentException('Nem megfelelő tevékenységi kör! Kérem, próbálja újra!');
        }
    }
    
    protected function saveKompetencia($jobId, $kompetenciaId)
    {
        if ((int)$kompetenciaId > 0) {
            parent::saveKompetencia($jobId, $kompetenciaId);
        } else {
            throw new \InvalidArgumentException('Nem megfelelő kompetencia! Kérem, próbálja újra!');
        }
    }
    
    protected function saveElvaras($jobId, $elvaras)
    {
        if ($this->isValidString($elvaras)) {
            parent::saveElvaras($jobId, $elvaras);
        } else {
            throw new \InvalidArgumentException('Az elvárásnak legalább 3 karakter hosszúnak kell lennie!');
        }
    }
    
    protected function saveFeladat($jobId, $feladat)
    {
        if ($this->isValidString($feladat)) {
            parent::saveFeladat($jobId, $feladat);
        } else {
            throw new \InvalidArgumentException('A feladatnak legalább 3 karakter hosszúnak kell lennie!');
        }
    }
    
    protected function saveAmitKinalunk($jobId, $amitKinalunk)
    {
        if ($this->isValidString($amitKinalunk)) {
            parent::saveAmitKinalunk($jobId, $amitKinalunk);
        } else {
            throw new \InvalidArgumentException('Az amit kínálunk opciónak legalább 3 karakter hosszúnak kell lennie!');
        }
    }
    
    protected function isValidString($value)
    {
        return strlen($value) >= 3;
    }
    
    public function getUserId()
    {
        return (int)UserLoginOut_Site_Controller::$_id;
    }
    
    public function findAllCompetence()
    {
        try {
            $query = "SELECT
                     kompetencia_id AS kompetencia_id,
                     kompetencia_nev AS Nev
                     FROM kompetencia
                     WHERE kompetencia_aktiv = 1 AND kompetencia_torolt = 0 AND tipus = 'sajat'
                        ";
            
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            
        }
        catch(Exception_MYSQL $e){
            
        }
    }
}