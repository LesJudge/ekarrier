<?php
class Ugyfel_List_Model extends \DynamicFiltersModel
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
    public $_fields = 'ugyfel.ugyfel_id AS ID, ugyfel.vezeteknev, ugyfel.keresztnev, ugyfel.nem,  
                       ugyfel.ugyfel_aktiv AS Aktiv, user.user_fnev AS felhasznalonev, ugyfel.email AS email, 
                       ugyfel.letrehozas_timestamp';
    //CAST(uamph.palyakezdo AS UNSIGNED) AS palyakezdo, uamph.regisztralt_munkanelkuli
    /**
     * JOIN
     * @var string
     */
    public $_join = 'INNER JOIN ugyfel_attr_szuletesi_adatok uasza ON ugyfel.ugyfel_id = uasza.ugyfel_id
        LEFT JOIN user_ugyfel ON ugyfel.ugyfel_id = user_ugyfel.ugyfel_id
        LEFT JOIN user ON user_ugyfel.user_id = user.user_id';
    //INNER JOIN ugyfel_attr_mp_helyzet uamph ON ugyfel.ugyfel_id = uamph.ugyfel_id 
    //INNER JOIN ugyfel_attr_projekt_informacio uapi ON ugyfel.ugyfel_id = uapi.ugyfel_id 
    
    public $tableHeader = array(
        'ugyfel.vezeteknev' => array(
            'label' => 'Vezetéknév',
            'width' => 15
        ),
        'ugyfel.keresztnev' => array(
            'label' => 'Keresztnév', 
            'width' => 15
        ),
        'user.user_fnev' => array(
            'label' => 'Felhasználónév'
        ),
        'ugyfel.email' => array(
            'label' => 'E-mail'
        ),
        'ugyfel.nem' => array(
            'label' => 'Nem'
        ),
        'ugyfel.letrehozas_timestamp' => array(
            'label' => 'Felvétel ideje'
        ),
        'ugyfel.ugyfel_aktiv' => array(
            'label' => 'Közzétéve'
        )
    );
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
        $this->_params['TxtSort']->_value = 'ugyfel.letrehozas_timestamp__DESC';
        // .xls export item.
        $this->addItem('TxtExportXls');
        // Dinamikus text input mezők.
        $textInputs = array(
            'Lastname', 'Firstname', 'Nickname', 'Email', 'Phone', 'Idotartam', 'PhoneMobile1', 'PhoneMobile2', 
            'Lakcim', 'BirthLastname', 'BirthFirstname', 'BirthplaceCountry', 'BirthplaceCity', 'Birthdate', 'MikorReg',
            'GyesGyedLejarDatum', 'KovFelulvDatum', 'MvegzesKeok'
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
        $eduTypes = ArHelper::result2Options(Education::findAllActiveNotDeleted(), 'vegzettseg_id', 'vegzettseg_nev');
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
            KnowledgeLanguage::findAllActiveNotDeleted(), 'nyelvtudas_nyelv_id', 'nyelvtudas_nyelv_nev'
        );
        // Nyelvtudás szint
        $klevel = $this->addDynamicFilter('NyelvtudasSzint');
        $klevel->_select_value = ArHelper::result2Options(
            KnowledgeLevel::findAllActiveNotDeleted(), 'nyelvtudas_szint_id', 'nyelvtudas_szint_nev'
        );
        // Nyelvtudás - összes szükséges.
        $this->addDynamicFilter('NyelvtudasMind');
        // Program információ
        $pi = $this->addDynamicFilter('ProgramInformacio');
        $pi->_select_value = ArHelper::result2Options(
            ProgramInformation::findAllActiveNotDeleted(), 'program_informacio_id', 'program_informacio_nev'
        );
        // Munkarend
        $ws = $this->addDynamicFilter('Munkarend');
        $ws->_select_value = ArHelper::result2Options(
            WorkSchedule::findAllActiveNotDeleted(), 'munkarend_id', 'munkarend_nev'
        );
        // Hova érkezett
        $ct = $this->addDynamicFilter('HovaErkezett');
        $ct->_select_value = ArHelper::result2Options(
            CameTo::findAllActiveNotDeleted(), 'hova_erkezett_id', 'hova_erkezett_nev'
        );
        // Állapot.
        $allapot = $this->addDynamicFilter('Allapot');
        $allapot->_select_value = $this->getSelectValues(
            'user_allapot', 
            'nev', 
            ' AND user_allapot_aktiv = 1 AND user_allapot_torolt = 0', 
            ' ORDER BY nev ASC', 
            false
        );
        // Aktuális státusz.
        $statuses = $this->getSelectValues(
            'user_statusz',
            'nev',
            ' AND user_statusz_aktiv = 1 AND user_statusz_torolt = 0',
            ' ORDER BY nev ASC ',
            false
        );
        $aktualisStatusz = $this->addDynamicFilter('AktualisStatusz');
        $aktualisStatusz->_select_value = $statuses;
        // Következő státusz.
        $kovetkezoStatusz = $this->addDynamicFilter('KovetkezoStatusz');
        $kovetkezoStatusz->_select_value = $statuses;
        // Nem
        $nem = $this->addDynamicFilter('Nem');
        $nem->_select_value = array(
            'male' => 'Férfi',
            'female' => 'Nő'
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
            //echo $query;
            //exit;
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function __loadListCount()
    {
        $this->__createWhere();         
        $query = "SELECT COUNT(DISTINCT(`{$this->_tableName}`.{$this->_tableName}_id)) AS cnt 
            FROM `{$this->_tableName}` {$this->_join} {$this->listWhere}";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array("cnt");
    }
}
