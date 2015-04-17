<?php
/**
 * @property MYSQL_DB $_DB Adatbázis.
 */
abstract class AllashirdetesBaseEditModel extends Admin_Edit_Model
{
    const TABLE_ATTR_AMIT_KINALUNK = 'allashirdetes_attr_amit_kinalunk';
    const TABLE_ATTR_ELVARAS = 'allashirdetes_attr_elvaras';
    const TABLE_ATTR_FELADAT = 'allashirdetes_attr_feladat';
    const TABLE_ATTR_TKOR = 'allashirdetes_attr_munkakor';
    const TABLE_ATTR_KOMP = 'allashirdetes_attr_kompetencia';
    const FIELD_ATTR_AMIT_KINALUNK = 'amit_kinalunk';
    const FIELD_ATTR_ELVARAS = 'elvaras';
    const FIELD_ATTR_FELADAT = 'feladat';
    const FIELD_ATTR_TKOR = 'munkakor_id';
    const FIELD_ATTR_KOMPETENCIA = 'kompetencia_id';
    const PI_AMIT_KINALUNK = 'ak';
    const PI_ELVARASOK = 'elvarasok';
    const PI_FELADATOK = 'feladatok';
    const PI_TKOR = 'tkor';
    const PI_KOMPETENCIAK = 'kompetenciak';
    const SHPT_PREFIX_AMIT_KINALUNK = 'amitKinalunkForm_#index#_';
    const SHPT_PREFIX_ELVARAS = 'elvarasForm_#index#_';
    const SHPT_PREFIX_FELADAT = 'feladatForm_#index#_';
    const SHPT_PREFIX_TKOR = 'tkorForm_#index#_';
    const SHPT_PREFIX_KOMPETENCIA = 'kompetenciaForm_#index#_';
    const NOTIFICATION_DIALY = 1;
    const NOTIFICATION_WEEKLY = 2;
    const NOTIFICATION_EXPIRE = 3;
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'allashirdetes';
    /**
     * _bindArray
     * @var array
     */
    public $_bindArray = array(
        'szektor_id' => 'SelSzektor',
        'pozicio_id' => 'SelPozicio',
        'cim_megye_id' => 'SelMegye',
        'cim_varos_id' => 'SelVaros',
        //'munkarend_id' => 'SelMunkarend',
        'mas_hirdetese' => 'ChkMasHirdetese',
        'mas_hirdetese_link' => 'TxtMasHirdeteseLink',
        'ceg_id' => 'SelCeg',
        'egyedi' => 'ChkEgyedi',
        'link' => 'TxtLink',
        'megnevezes' => 'TxtNev',
        'munkavegzes_jellege' => 'TxtMunkavegzesJellege',
        'munkaber' => 'TxtMunkaber',
        'probaido' => 'TxtProbaido',
        'egyeb' => 'TxtEgyeb',
        //'ismerteto' => 'TxtIsmerteto',
        'jelentkezes_modja' => 'TxtJelMod',
        'jelentkezes_hatarideje' => 'DateJelentkezesHatarideje',
        'munkakezdes_ideje' => 'DateMunkakezdesIdeje',
        //'utca' => 'TxtUtca',
        //'hazszam' => 'TxtHazszam',
        'lejarati_datum' => 'DateLejar',
        'kezdes_datum' => 'DateKezdes',
        //'ertesites_mikor' => 'SelErtesites',
        'ellenorzott' => 'ChkEllenorzott',
        'allashirdetes_aktiv' => 'ChkAktiv',
    );
    /**
     * Form elkészítése.
     */
    public function __addForm()
    {
        parent::__addForm();
        // Név
        $this->addItem('TxtNev')->_verify['string'] = true;
        // Link
        $this->addItem('TxtLink');
        // Cég
        $this->addItem('SelCeg');
        // Szektor
        $sector = $this->addItem('SelSzektor');
        $sector->_verify['select'] = true;
        $sector->_select_value = $this->getSelectValues(
            'szektor',
            'szektor_nev',
            ' AND szektor_aktiv = 1 AND szektor_torolt = 0',
            ' ORDER BY szektor_nev ASC',
            false,
            array('' => '--Válasszon szektort!--')
        );
        // Pozíció
        $position = $this->addItem('SelPozicio');
        $position->_verify['select'] = true;
        $position->_select_value = $this->getSelectValues(
            'pozicio',
            'pozicio_nev',
            ' AND pozicio_aktiv = 1 AND pozicio_torolt = 0',
            ' ORDER BY pozicio_nev ASC',
            false,
            array('' => '--Válasszon pozíciót!--')
        );
        // Más hirdetése
        $this->addItem('ChkMasHirdetese');
        // Más hirdetése link
        $this->addItem('TxtMasHirdeteseLink');
        // Munkarend
        /*
        $mr = $this->addItem('SelMunkarend');
        $mr->_verify['select'] = true;
        $mr->_select_value = $this->getSelectValues(
            'munkarend',
            'nev',
            ' AND munkarend_aktiv = 1 AND munkarend_torolt = 0',
            ' ORDER BY nev ASC',
            false,
            array('' => '--Válasszon munkarendet!--')
        );
        */
        // Ismertető
        //$this->addItem('TxtIsmerteto')->_verify['string'] = true;
        // Jelentkezés módja
        $this->addItem('TxtJelMod');
        // Jelentkezés határideje
        $jelentkezesDeadline = $this->addItem('DateJelentkezesHatarideje');
        $jelentkezesDeadline->_verify['date'] = true;
        
        //Munkakezdés ideje
        $munkakezdesDeadline = $this->addItem('DateMunkakezdesIdeje');
        $munkakezdesDeadline->_verify['date'] = true;
        
        
        // Megye.
        $ps = array('' => '--Kérem, válasszon!--');
        $county = $this->addItem('SelMegye');
        $county->_verify['select'] = true;
        $county->_select_value = $this->getSelectValues(
            'cim_megye', 
            'cim_megye_nev', 
            ' AND cim_megye_aktiv = 1 AND cim_megye_torolt = 0 ', 
            ' ORDER BY cim_megye_nev ASC', 
            false, 
            $ps
        );
        // Város.
        $city = $this->addItem('SelVaros');
        $city->_verify['select'] = true;
        $city->_select_value = $this->getSelectValues(
            'cim_varos', 
            'cim_varos_nev', 
            ' AND cim_varos_aktiv = 1 AND cim_varos_torolt = 0 ', 
            ' ORDER BY cim_varos_nev ASC', 
            false, 
            $ps
        );
        // Utca
        //$this->addItem('TxtUtca');
        // Házszám
        //$this->addItem('TxtHazszam');
        // Lejárati dátum
        $deadline = $this->addItem('DateLejar');
        $deadline->_verify['date'] = true;
        
        $start = $this->addItem('DateKezdes');
        $start->_verify['date'] = true;
        
        // Értesítés
        /*
        $notification = $this->addItem('SelErtesites');
        $notification->_verify['select'] = true;
        $notification->_select_value = $ps + array(
            self::NOTIFICATION_DIALY => 'Naponta',
            self::NOTIFICATION_EXPIRE => 'Lejáratkor',
            self::NOTIFICATION_WEEKLY => 'Hetente'
        );
        */
        // Ellenőrzött álláshirdetés
        $this->addItem('ChkEllenorzott');
        // Egyedi álláshirdetés-e.
        $this->addItem('ChkEgyedi');
        // Munkavégzés jellege.
        $this->addItem('TxtMunkavegzesJellege');
        // Munkabér
        $this->addItem('TxtMunkaber');
        // Próbaidő
        $this->addItem('TxtProbaido');
        // Egyéb.
        $this->addItem('TxtEgyeb');
    }
    /**
     * SEO URL elkészítése.
     */
    public function removeAccentsFromLink()
    {
        $this->_params['TxtLink']->_value = Create::remove_accents($this->_params['TxtLink']->_value);
    }
    /**
     * Eltávolítja az elválasztókat a kulcsszóból.
     */
    public function removeDelimitterFromKulcsszo()
    {
        while (strpos($this->_params['TxtKulcsszo']->_value, ',,') !== false) {
            $this->_params['TxtKulcsszo']->_value = str_replace(',,', ',', $this->_params['TxtKulcsszo']->_value);
        }
    }
    /**
     * 
     * @return array
     */
    public function __editData()
    {
        $jobId = $this->modifyID;
        $munkakor = $this->findMunkakorByJobId($jobId);
        $json = array();
        if (!empty($munkakor)) {
            foreach ($munkakor as $m) {
                $json[] = array(
                    self::SHPT_PREFIX_TKOR . 'munkakor_id' => $m['munkakor_id'],
                    self::SHPT_PREFIX_TKOR . 'munkakor_nev' => $m['munkakor_nev'],
                    self::SHPT_PREFIX_TKOR . 'munkakor_al_id' => $m['munkakor_al_id'],
                    self::SHPT_PREFIX_TKOR . 'munkakor_fo_id' => $m['munkakor_fo_id']
                );
            }
        }
        
        $json2 = array();
        $kompetencia = $this->findKompetenciaByJobId($jobId);
        if (!empty($kompetencia)) {
            foreach ($kompetencia as $k) {
                $json2[] = array(
                    self::SHPT_PREFIX_KOMPETENCIA . 'kompetencia_id' => $k['kompetencia_id']
                );
            }
        }
        //print_r($json2);
        
        return array(
            //'tkorok' => array(),
            'tkorok' => json_encode($json),
            //'kompetenciak' => json_encode($json2),
            'kompetenciak' => $this->data2SheepItJson(
                $this->findKompetenciaByJobId($jobId),
                self::FIELD_ATTR_KOMPETENCIA,
                self::SHPT_PREFIX_KOMPETENCIA
            ),
            'elvarasok' => $this->data2SheepItJson(
                $this->findElvarasByJobId($jobId),
                self::FIELD_ATTR_ELVARAS,
                self::SHPT_PREFIX_ELVARAS
            ),
            'feladatok' => $this->data2SheepItJson(
                $this->findFeladatByJobId($jobId),
                self::FIELD_ATTR_FELADAT,
                self::SHPT_PREFIX_FELADAT
            ),
            'amitKinalunk' => $this->data2SheepItJson(
                $this->findAmitKinalunkByJobId($jobId),
                self::FIELD_ATTR_AMIT_KINALUNK,
                self::SHPT_PREFIX_AMIT_KINALUNK
            )
        );
    }
    /**
     * Új álláshirdetés mentése.
     */
    public function __insert($sets = '')
    {
        $jobId = &$this->insertID;
        $userId = $this->getUserId();
        if(empty($this->_params['DateKezdes']->_value)){
            $this->_params['DateKezdes']->_value = date("Y-m-d");
        }
        parent::__insert(',letrehozo = ' . $userId . ', modosito = ' . $userId);
        // sheepIt adatok mentése.
        $this->saveAllMunkakor($jobId);
        $this->saveAllAmitKinalunk($jobId);
        $this->saveAllElvaras($jobId);
        $this->saveAllFeladat($jobId);
        $this->saveAllKompetencia($jobId);
    }
    /**
     * Álláshirdetés módosítása.
     */
    public function __update($sets = '')
    {
        $jobId = $this->modifyID;
        
        if(empty($this->_params['DateKezdes']->_value)){
            $this->_params['DateKezdes']->_value = date("Y-m-d");
        }
        
        // sheepIt adatok mentése.
        $this->saveAllMunkakor($jobId, true);
        $this->saveAllAmitKinalunk($jobId, true);
        $this->saveAllElvaras($jobId, true);
        $this->saveAllFeladat($jobId, true);
        $this->saveAllKompetencia($jobId, true);
        parent::__update(
            ',modositas_timestamp=now() ,modositas_szama=modositas_szama+1 ,modosito=' . $this->getUserId()
        );
    }
    /**
     * Munkarend azonosító alapján lekérdezi a munkarend nevét.
     * @param int $id Munkarend azonosító.
     * @return string
     * @throws \Exception_MYSQL_Null_Rows
     */
    public function findMunkarendById($id)
    {
        $query = "SELECT munkarend_nev 
                  FROM munkarend 
                  WHERE munkarend_id = " . (int)$id. " AND munkarend_aktiv = 1 AND munkarend_torolt = 0 
                  LIMIT 1";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array('munkarend_nev');
    }
    /**
     * Lekérdezi az összes várost az autocompletehez.
     * @return string
     */
    public function findCities4Autocomplete()
    {
        $cities = UserAddressFinder::model()->findCities();
        $result = array();
        foreach ($cities as $id => $name) {
            $result[] = array(
                'label' => $name,
                'value' => $id
            );
        }
        return json_encode($result);
    }
    /**
     * Megvizsgálja, hogy a $_POST tömb paraméterül aodtt indexe megfelelő, menthető sheepItForm elemeket tartalmaz-e.
     * @param string $index
     * @return boolean
     */
    protected function isValidSheepIt($index)
    {
        return isset($_POST[$index]) && is_array($_POST[$index]) && !empty($_POST[$index]);
    }
    /**
     * sheepItFormmal kompatibilis JSON stringgé alakítja a kapott eredményhalmazt.
     * @param array $data Eredményhalmaz
     * @param string $index Index, aminek az értékére szükségünk van.
     * @param string $keyPrefix sheepItForm prefix.
     * @return string
     */
    protected function data2SheepItJson(array $data, $index, $keyPrefix)
    {
        $result = array();
        foreach ($data as $item) {
            $result[] = array($keyPrefix . $index => $item[$index]);
        }
        return json_encode($result);
    }
    /**
     * Menti a paraméterül adott összes sheepItForm elemet.
     * @param int $jobId Álláshirdetés azonosító.
     * @param array $data Kapott eredményhalmaz.
     * @param string $method Metódus, amit meg kell hívnia.
     */
    protected function saveAllSheepItData($jobId, array $data, $method)
    {
        $data = array_unique($data);
        foreach ($data as $value) {
            call_user_func(array($this, $method), $jobId, $value);
        }
    }
    /**
     * Lekérdezi a paraméterül adott táblából az összes opciót.
     * @param string $table Tábla neve
     * @param string $field Mező neve
     * @return array
     */
    protected function findSheepItData($table, $field)
    {
        $query = "SELECT " . $field . " FROM " . $table . " GROUP BY " . $field . " ORDER BY " . $field . " ASC";
        try {
            $queryResult = $this->_DB->prepare($query)->query_select();
            $result = array();
            while ($data = $queryResult->query_fetch_array()) {
                $result[] = $data[$field];
            }
            return $result;
        } catch (Exception $ex) {
            return array();
        }
    }
    
    protected function findJobSpecificSheepItData($table, $field, array $jobIds)
    {
        try {
            $query = "SELECT 
                          t." . $field . "
                      FROM
                          " . $table . " t
                              INNER JOIN
                          allashirdetes_attr_munkakor aam ON t.allashirdetes_id = aam.allashirdetes_id
                      WHERE
                          aam.munkakor_id IN (" . implode(',', $jobIds) . ")
                      GROUP BY t." . $field . "
                      ORDER BY t." . $field . " ASC";
            $queryResult = $this->_DB->prepare($query)->query_select();
            $result = array();
            while ($data = $queryResult->query_fetch_array()) {
                $result[] = $data[$field];
            }
            return $result;
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    /**
     * Lekérdezi az álláshirdetéshez tartozó összes opciót a paraméterül adott táblából.
     * @param int $jobId Álláshirdetés azonosító
     * @param string $table Tábla neve
     * @param string $field Mező neve
     * @return array
     */
    protected function findSheepItDataByJobId($jobId, $table, $field)
    {
        $query = "SELECT " . $field . " FROM " . $table . " WHERE allashirdetes_id = " . (int)$jobId;
        try {
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception $ex) {
            return array();
        }
    }
    /**
     * Menti a paraméterül adott táblába az álláshirdetéshez tartozó opciót.
     * @param int $jobId Álláshirdetés azonosító
     * @param string $table Opciókat tároló tábla neve
     * @param string $field Opciót tároló mező neve
     * @param string $value Opció
     */
    protected function saveSheepItData($jobId, $table, $field, $value)
    {
        $query = "INSERT INTO " . $table . " (allashirdetes_id, " . $field . ") VALUES 
            (" . $jobId . ", '" . mysql_real_escape_string($value) . "')";
        //echo $query."<br>";
        $this->_DB->prepare($query)->query_insert();
    }
    /**
     * Törli a paraméterül adott táblából az álláshirdetéshez tartozó összes opciót.
     * @param int $jobId Álláshirdetéshez azonosító
     * @param string $table Tábla neve
     */
    protected function deleteSheepItData($jobId, $table)
    {
        $query = "DELETE FROM " . $table . " WHERE allashirdetes_id = " . (int)$jobId;
        $this->_DB->prepare($query)->query_execute();
    }
    /**
     * Visszatér az összes aktív, nem törölt munkakörrel.
     * @return array
     */
    public function findAllMunkakor()
    {
        try {
            $query = "SELECT munkakor_id, munkakor_nev
                      FROM munkakor
                      WHERE munkakor_aktiv = 1 AND munkakor_torolt = 0";
            $queryResult = $this->_DB->prepare($query)->query_select();
            $result = array();
            while ($data = $queryResult->query_fetch_array()) {
                $result[] = array(
                    'label' => $data['munkakor_nev'],
                    'value' => $data['munkakor_id']
                );
            }
            return $result;
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    /**
     * Lekérdezi az összes "Amit kínálunk" opciót.
     * @return array
     */
    public function findAllAmitKinalunk()
    {
        return $this->findSheepItData(self::TABLE_ATTR_AMIT_KINALUNK, self::FIELD_ATTR_AMIT_KINALUNK);
    }
    /**
     * Lekérdezi az összes "Elvárás" opciót.
     * @return array
     */
    public function findAllElvaras(array $jobIds)
    {
        return $this->findJobSpecificSheepItData(self::TABLE_ATTR_ELVARAS, self::FIELD_ATTR_ELVARAS, $jobIds);
    }
    /**
     * Lekérdezi az összes Feladat opciót.
     * @return array
     */
    public function findAllFeladat(array $jobIds)
    {
        return $this->findJobSpecificSheepItData(self::TABLE_ATTR_FELADAT, self::FIELD_ATTR_FELADAT, $jobIds);
    }
    /**
     * Lekérdezi az álláshirdetéshez tartozó összes "Amit kínálunk" opciót.
     * @param int $jobId Álláshirdetés azonosító
     * @return array
     */
    public function findAmitKinalunkByJobId($jobId)
    {
        return $this->findSheepItDataByJobId($jobId, self::TABLE_ATTR_AMIT_KINALUNK, 'amit_kinalunk');
    }
    /**
     * Lekérdezi az álláshirdetéshez tartozó összes "Elvárás" opciót.
     * @param int $jobId Álláshirdetés azonosító
     * @return array
     */
    public function findElvarasByJobId($jobId)
    {
        return $this->findSheepItDataByJobId($jobId, self::TABLE_ATTR_ELVARAS, 'elvaras');
    }
    
    public function findKompetenciaByJobId($jobId)
    {
        
        return $this->findSheepItDataByJobId($jobId, self::TABLE_ATTR_KOMP, 'kompetencia_id');
    }
    
    /**
     * Lekérdezi az álláshirdetéshez tartozó összes "Feladat" opciót.
     * @param int $jobId Álláshirdetés azonosító
     * @return array
     */
    public function findFeladatByJobId($jobId)
    {
        return $this->findSheepItDataByJobId($jobId, self::TABLE_ATTR_FELADAT, 'feladat');
    }
    /**
     * Visszatér az álláshirdetéshez tartozó munkakörökkel.
     * @param int $jobId Álláshirdetés azonosító.
     * @return array
     */
    public function findMunkakorByJobId($jobId)
    {
        try {
            $query = "SELECT job_id, job_name, sub_id, main_id FROM allashirdetes_attr_munkakor aam 
                INNER JOIN munkakor_view mv ON aam.munkakor_id = mv.job_id
                WHERE aam.allashirdetes_id = " . (int)$jobId;
            $queryResult = $this->_DB->prepare($query)->query_select();
            $result = array();
            while ($data = $queryResult->query_fetch_array()) {
                $result[] = array(
                    'munkakor_id' => $data['job_id'],
                    'munkakor_nev' => $data['job_name'],
                    'munkakor_al_id' => $data['sub_id'],
                    'munkakor_fo_id' => $data['main_id']
                );
            }
            return $result;
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    /*
    public function findKompetenciaByJobId($jobId)
    {
        try {
            $query = "SELECT k.kompetencia_id FROM kompetencia k 
                INNER JOIN allashirdetes_attr_kompetencia aak ON k.kompetencia_id = aak.kompetencia_id
                WHERE aak.allashirdetes_id = " . (int)$jobId;
            $queryResult = $this->_DB->prepare($query)->query_select();
            $result = array();
            while ($data = $queryResult->query_fetch_array()) {
                $result[] = array(
                    'kompetencia_id' => $data['kompetencia_id']
                );
            }
            return $result;
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }*/
    /**
     * Menti az álláshirdetéshez a "Munkakör" opciót.
     * @param int $jobId Álláshirdetés azonosító.
     * @param int $munkakorId Munkakör azonosító.
     */
    protected function saveMunkakor($jobId, $munkakorId)
    {
        $this->saveSheepItData($jobId, self::TABLE_ATTR_TKOR, self::FIELD_ATTR_TKOR, $munkakorId);
    }
    
    protected function saveKompetencia($jobId, $kompetenciaId)
    {
        $this->saveSheepItData($jobId, self::TABLE_ATTR_KOMP, self::FIELD_ATTR_KOMPETENCIA, $kompetenciaId);
    }
    /**
     * Menti az álláshirdetéshez az "Amit kínálunk" opciót.
     * @param int $jobId Álláshirdetés azonosító
     * @param string $amitKinalunk Amit kínálunk opció
     */
    protected function saveAmitKinalunk($jobId, $amitKinalunk)
    {
        $this->saveSheepItData($jobId, self::TABLE_ATTR_AMIT_KINALUNK, self::FIELD_ATTR_AMIT_KINALUNK, $amitKinalunk);
    }
    /**
     * Menti az álláshirdetéshez az "Elvárás" opciót.
     * @param int $jobId Álláshirdetés azonosító
     * @param string $elvaras Elvárás opció
     */
    protected function saveElvaras($jobId, $elvaras)
    {
        $this->saveSheepItData($jobId, self::TABLE_ATTR_ELVARAS, self::FIELD_ATTR_ELVARAS, $elvaras);
    }
    /**
     * Menti az álláshirdetéshez a "Feladat" opciót.
     * @param int $jobId Álláshirdetés azonosító
     * @param string $feladat Feladat opció
     */
    protected function saveFeladat($jobId, $feladat)
    {
        $this->saveSheepItData($jobId, self::TABLE_ATTR_FELADAT, self::FIELD_ATTR_FELADAT, $feladat);
    }
    /**
     * Menti az összes sheepItForm elemet.
     * @param int $jobId Álláshirdetés azonosító.
     * @param string $index $_POST index.
     * @param boolean $deleteBefore Törölje-e a rekordokat mentés előtt.
     * @param string $deleteMethod Törlés metódus neve.
     * @param string $saveMethod Mentés metódus neve.
     */
    protected function saveAllSheepItFormItem($jobId, $index, $deleteBefore, $deleteMethod, $saveMethod)
    {
        if ($deleteBefore === true) {
            call_user_func(array($this, $deleteMethod), $jobId);
        }
        if ($this->isValidSheepIt($index)) {
            call_user_func(array($this, 'saveAllSheepItData'), $jobId, $_POST[$index], $saveMethod);
        }
    }
    /**
     * Menti az álláshirdetéshez tartozó munkaköröket.
     * @param int $jobId Álláshirdetés azonosító.
     * @param boolean $deleteBefore Törölje-e az eddigi rekordokat.
     */
    protected function saveAllMunkakor($jobId, $deleteBefore = false)
    {
        if ($deleteBefore === true) {
            $this->deleteAllMunkakorByJobId($jobId);
        }
        $tks = $_POST[self::PI_TKOR];
        foreach ($tks as $tk) {
            $this->saveMunkakor($jobId, $tk['munkakor_id']);
        }
    }
    
    protected function saveAllKompetencia($jobId, $deleteBefore = false)
    {
        if ($deleteBefore === true) {
            $this->deleteAllKompetenciaByJobId($jobId);
        }
        //print_r($_POST);
        $kompetenciak = $_POST[self::PI_KOMPETENCIAK];
        foreach ($kompetenciak as $kompetencia) {
            $this->saveKompetencia($jobId, $kompetencia['kompetencia_id']);
        }
    }
    
    /**
     * Menti az álláshirdetéshez a sheepItForm-ban felvett amit kínálunk opciókat.
     * @param int $jobId Álláshirdetés azonosító.
     * @param boolean $deleteBefore Törölje-e az eddigi rekordokat.
     */
    protected function saveAllAmitKinalunk($jobId, $deleteBefore = false)
    {
        $this->saveAllSheepItFormItem(
            $jobId,
            self::PI_AMIT_KINALUNK,
            $deleteBefore,
            'deleteAllAmitKinalunkByJobId',
            'saveAmitKinalunk'
        );
    }
    /**
     * Menti az álláshirdetéshez a sheepItForm-ban felvett elvárásokat.
     * @param int $jobId Álláshirdetés azonosító.
     * @param boolean $deleteBefore Törölje-e az eddigi rekordokat.
     */    
    protected function saveAllElvaras($jobId, $deleteBefore = false)
    {
        $this->saveAllSheepItFormItem(
            $jobId,
            self::PI_ELVARASOK,
            $deleteBefore,
            'deleteAllElvarasByJobId',
            'saveElvaras'
        );
    }
    /**
     * Menti az álláshirdetéshez a sheepItForm-ban felvett feladatokat.
     * @param int $jobId Álláshirdetés azonosító.
     * @param boolean $deleteBefore Törölje-e az eddigi rekordokat.
     */
    protected function saveAllFeladat($jobId, $deleteBefore = false)
    {
        $this->saveAllSheepItFormItem(
            $jobId,
            self::PI_FELADATOK,
            $deleteBefore,
            'deleteAllFeladatByJobId',
            'saveFeladat'
        );
    }
    /**
     * Törli az álláshirdetéshez tartozó összes "Munkakör" opciót.
     * @param int $jobId Álláshirdetés azonosító.
     */
    protected function deleteAllMunkakorByJobId($jobId)
    {
        $this->deleteSheepItData($jobId, self::TABLE_ATTR_TKOR);
    }
    
    protected function deleteAllKompetenciaByJobId($jobId)
    {
        $this->deleteSheepItData($jobId, self::TABLE_ATTR_KOMP);
    }
    /**
     * Törli az álláshirdetéshez tartozó összes "Amit kínálunk" opciót.
     * @param int $jobId Álláshirdetés azonosító
     */
    protected function deleteAllAmitKinalunkByJobId($jobId)
    {
        $this->deleteSheepItData($jobId, self::TABLE_ATTR_AMIT_KINALUNK);
    }
    /**
     * Törli az álláshirdetéshez tartozó összes "Elvárás" opciót.
     * @param int $jobId Álláshirdetés azonosító
     */
    protected function deleteAllElvarasByJobId($jobId)
    {
        $this->deleteSheepItData($jobId, self::TABLE_ATTR_ELVARAS);
    }
    /**
     * Törli az álláshirdetéshez tartozó összes "Feladat" opciót.
     * @param int $jobId Álláshirdetés azonosító
     */
    protected function deleteAllFeladatByJobId($jobId)
    {
        $this->deleteSheepItData($jobId, self::TABLE_ATTR_FELADAT);
    }
    
    abstract public function getUserId();
}