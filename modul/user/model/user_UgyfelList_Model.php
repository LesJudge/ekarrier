<?php
/**
 * @property MYSQL_DB $_DB Adatbázis.
 */
class User_UgyfelList_Model extends DynamicFiltersModel
{
    /**
     * Tábla neve.
     * @var string 
     */
    public $_tableName = 'ugyfel';
    /**
     * Kiválasztott mezők.
     * @var string 
     */
    public $_fields = 'ugyfel.ugyfel_id AS ID, ugyfel.vezeteknev AS elso';
    /**
     * Visszatér a dinamikus szűrők prefixével.
     * @return string
     */
    public function dynamicFiltersPrefix()
    {
        return 'ugyfelDf';
    }
    /**
     * Legenerálja form elemeket.
     * @return void
     */
    public function __addForm()
    {
        parent::__addForm();
        // .xls export item.
        $this->addItem('TxtExportXls');
        // Dinamikus text input mezők.
        $textInputs = array(
            'Lastname', 'Firstname', 'Nickname', 'Email', 'Phone', 'Lakcim', 'Birthname', 'Birthplace', 'Birthdate', 
            'MikorReg', 'GyesGyedLejarDatum', 'KovFelulvDatum', 'MvegzesKeok'
        );
        foreach ($textInputs as $textInput) {
            $this->addDynamicFilter($textInput);
        }
        // True or false mezők.
        $tofInputs = array(
            'Palyakezdo', 'Regmunkanelk', 'GyesGyedVisszatero', 'MegvMkep', 'Dolgozik', 'EuProgElmKetEv',
            'HazaiProgElmKetEv', 'KozAdatbKerul', 'HozzajarulMunkakozv', 'MobilitastVallal', 'KkTreningResztvett',
            'GrafElemzResztvett', 'JogiTadasResztvett', 'KepzTanadResztvett', 'MunkaTanadResztvett',
            'PszichTanadResztvett', 'EgyMegallKtttnkProg', 'EgyMegallKtttnkKepz', 'Newsletter', 'Active'
        );
        foreach ($tofInputs as $tofInput) {
            $item = $this->addDynamicFilter($tofInput);
            $item->_select_value = array(0 => 'Nem', 1 => 'Igen');
        }
        // Melyik képzésbe került be szűrő.
        $kepzes = $this->addDynamicFilter('KepzesBekerult');
        $kepzes->_select_value = $this->getSelectValues(
            'kepzes',
            'kepzes_nev',
            ' AND kepzes_aktiv = 1 AND kepzes_torolt = 0',
            ' ORDER BY kepzes_nev ASC',
            false
        );
        // Végzettség szűrők
        $eduTypes = ArHelper::result2Options(Education::findAllActiveNotDeleted(), 'vegzettseg_id', 'nev');
        // Iskola
        $this->addDynamicFilter('VegzettsegIskola');
        // Kezdés
        $this->addDynamicFilter('VegzettsegKezdes');
        // Végzés
        $this->addDynamicFilter('VegzettsegVegzes');
        // Szak
        $this->addDynamicFilter('VegzettsegSzak');
        // Iskolai végzettség
        $edusMultiple = $this->addDynamicFilter('VegzettsegSzint');
        $edusMultiple->_select_value = $eduTypes;
        // Számítógépes ismeretek szűrő (Az ismeret neve).
        $this->addDynamicFilter('SzIsmeret');
        // Számítógépes ismeretek szűrő (A szűrés módja - LIKE).
        $this->addDynamicFilter('SzIsmeretLike');
        // Számítógépes ismeretek szűrő (Mindegyik ismeret "kötelező"-e).
        $this->addDynamicFilter('SzIsmeretMind');
        // Nyelvtudás nyelv
        $klang = $this->addDynamicFilter('NyelvtudasNyelv');
        $klang->_select_value = ArHelper::result2Options(
            KnowledgeLanguage::findAllActiveNotDeleted(), 'nyelvtudas_nyelv_id', 'nev'
        );
        // Nyelvtudás szint
        $klevel = $this->addDynamicFilter('NyelvtudasSzint');
        $klevel->_select_value = ArHelper::result2Options(
            KnowledgeLevel::findAllActiveNotDeleted(), 'nyelvtudas_szint_id', 'nev'
        );
        // Nyelvtudás - összes szükséges.
        $this->addDynamicFilter('NyelvtudasMind');
        // Program információ
        $pi = $this->addDynamicFilter('ProgramInformacio');
        $pi->_select_value = ArHelper::result2Options(
            ProgramInformation::findAllActiveNotDeleted(), 'program_informacio_id', 'nev'
        );
        // Munkarend
        $ws = $this->addDynamicFilter('Munkarend');
        $ws->_select_value = ArHelper::result2Options(
            WorkSchedule::findAllActiveNotDeleted(), 'munkarend_id', 'nev'
        );
        // Hova érkezett
        $ct = $this->addDynamicFilter('HovaErkezett');
        $ct->_select_value = ArHelper::result2Options(
            CameTo::findAllActiveNotDeleted(), 'karrierpont_id', 'nev'
        );
        $db = $this->_DB;
        $getResult = function($table, $id, $name) use ($db) {
            try {
                $result = $db->prepare(
                    'SELECT ' . $id . ', ' . $name . ' FROM ' . $table . ' ORDER BY ' . $name . ' ASC'
                )->query_select();
                $counties = array();
                while ($data = $result->query_fetch_array()) {
                    $counties[$data[$id]] = $data[$name];
                }
            } catch (\Exception_MYSQL_Null_Rows $emnr) {
                $counties = array();
            }
            return $counties;
        };
        // Megye szűrő.
        $county = $this->addDynamicFilter('CimMegye');
        $county->_select_value = $getResult('cim_megye', 'cim_megye_id', 'cim_megye_nev');
        // Település szűrő.
        $city = $this->addDynamicFilter('CimVaros');
        $city->_select_value = $getResult('cim_varos', 'cim_varos_id', 'cim_varos_nev');
    }
    
    public function __createWhere()
    {
        //echo __METHOD__, '<br />';
        //var_dump($this->listWhere);
        //echo '<br />';
        //if (is_array($this->listWhere)) {
            $felt_array = "{$this->_tableName}_torolt=0 AND " . implode(" AND ", $this->listWhere);
            $this->listWhere = " WHERE {$felt_array}";
        //}
    }    
    /**
     * Lista lekérdezése.
     * @return array
     * @throws \Exception_MYSQL_Null_Rows
     * @throws \Exception_MYSQL
     */
    public function __loadList()
    {
        if(!empty($this->sortBY)){
            $order = " ORDER BY {$this->sortBY}";
        } 
        $query =  "SELECT {$this->_fields} FROM `{$this->_tableName}` {$this->_join} {$this->listWhere} 
            GROUP BY `{$this->_tableName}`.{$this->_tableName}_id {$order} {$this->limit}";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function __loadListCount()
    {
        $this->__createWhere();         
        $query = "SELECT COUNT(DISTINCT(`{$this->_tableName}`.{$this->_tableName}_id)) AS cnt FROM `{$this->_tableName}` {$this->_join} {$this->listWhere}";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array("cnt");
    }
}