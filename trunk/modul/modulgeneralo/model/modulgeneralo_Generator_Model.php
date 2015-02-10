<?php
/**
 * Rimo Modulgeneráló modul - Model
 * 
 * @property array $_bindArray => A validációs szabályokat határozza meg.
 * @property-read string $PATTERN => Reguláris kifejezés a modul és a tábla nevére.
 * 
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Modulgeneralo_Generator_Model extends Page_Edit_Model{
    
    const PATTERN = '/^[a-z]{2,}[a-z_]*$/';
    //const APP_ROOT = 'modul/modulgeneralo/';
    const TEMPLATE_ROOT = 'modul/modulgeneralo/template';
    const INPUT_ROOT = 'modul/modulgeneralo/inputtemplate';
    
    public $_bindArray = array(
        'modulgeneralo_modulnev' => 'TxtModulNev',
        'modulgeneralo_tablanev' => 'TxtTablaNev',
        'modulgeneralo_publikusnev' => 'TxtPublikusNev',
    );
    
    public function __addForm(){
        parent::__addForm();
        // Modul név
        $modulnev = $this->addItem('TxtModulNev');
        $modulnev->_verify['required'] = true;
        $modulnev->_verify['pattern'] = array(
            'pattern' => self::PATTERN, // A minta.
            'value' => true, // Ezzel az értékkel kell visszatérnie a preg_match() függvénynek, hogy ne dobjon hibát.
            'message' => 'A modul neve nem illik a megadott mintára!',
        ); // Megvizsgálja, hogy a megadott név illik-e a mintára. Ha nem, hibát dob.
        $modulnev->_verify['isDir'] = array(
            'dirRoute' => 'modul/',
            'value' => false,
            'message' => 'A megadott könyvtár már létezik! Kérlek, válassz másikat!'
        ); // Megvizsgálja, hogy a megadott könyvtár létezik-e. Ha igen, hibát dob.
        // Tábla név
        $tablanev = $this->addItem('TxtTablaNev');
        $tablanev->_verify['required'] = true;
        $tablanev->_verify['pattern'] = array(
            'pattern' => self::PATTERN,
            'value' => true,
            'message' => 'A megadott táblanév nem illik a mintára!',
        );
        $tablanev->_verify['tableExists'] = $this->_DB; // Megvizsgálja, hogy a megadott táblanév létezik-e az adatbázisban. Ha igen, hibát dob.
        // Publikus név
        $publikusnev = $this->addItem('TxtPublikusNev');
        $publikusnev->_verify['string'] = true;
        // Form elemek inicializálása.
        $this->fieldFormInit();
    }
    
    protected function fieldFormInit()
    {
        // Igaz-hamis select
        $tof = $this->addItem('TrueOrFalseSel');
        $tof->_select_value = Rimo::$_config->TRUE_OR_FALSE;
        // Mező típusok select
        $fts = $this->addItem('FieldtypeSel');
        $fts->_select_value = Rimo::$_config->FIELDTYPES;
        // Típusok select
        $ts = $this->addItem('TypeSel');
        $ts->_select_value = Rimo::$_config->TYPES;
        // Nyelvesített
        $ny = $this->addItem('ChkNyelvesitett');
        // Validáció
        $val = $this->addItem('ChkValidacio');
        // sheepIt
        $sh = $this->addItem('ChkSheepit');
        // TinyMCE
        $tmce = $this->addItem('ChkTinyMCE');
        // prettyPhoto
        $pp = $this->addItem('ChkprettyPhoto');
    }
    
    public function __newData() {
        $this->_params['ChkNyelvesitett']->_value = 1;
        $this->_params['ChkValidacio']->_value = 0;
        $this->_params['ChkSheepit']->_value = 0;
        $this->_params['ChkTinyMCE']->_value = 0;
        $this->_params['ChkprettyPhoto']->_value = 0;
    }
    
    /**
     * Regisztrálja a modult a 'modulok' táblában.
     * @param array $moduleData => A modulhoz tartozó adatok.
     * 
     * A paraméter tömböt az alábbi formátumban kell megadni:
     * <b>$array = array('modul_azon' => 'A modul azonosítója', 'modul_nev' => 'A modul neve')</b>
     */
    public function registerModul(array $moduleData){
        try{
            $query = "INSERT INTO modul (modul_azon, modul_nev, modul_aktiv, modul_torolt) 
                      VALUES ('".mysql_real_escape_string($moduleData['modul_azon'])."', '".mysql_real_escape_string($moduleData['modul_nev'])."', 1 ,0)";
            $this->_DB->prepare($query)->query_insert();
        }
        catch(Exception_MYSQL_Null_Affected_Rows $e){
            throw new Exception_MYSQL('A modul regisztrálása sikertelen volt!');
        }
    }
    
    /**
     * Regisztrálja a modul/model "funkcióit" a modul_functions táblában.
     * @param array $moduleData => A modul vagy model adatait tartalmazó tömb.
     * @param boolean $list => Listázó funkcióval vegye-e fel. Alapértelmezetten true. Ha false-ra állítjuk, akkor "edit" funkcióként regisztrálja.
     * @throws Exception_MYSQL_Null_Affected_Rows => Ha nem sikerült rögzíteni a sort.
     * @throws Exception_MYSQL => Ha hibás a lekérdezés.
     */
    public function registerFunctions(array $moduleData, $list = true){
        try{
            $function_nev = mysql_real_escape_string($moduleData['modul_function_nev']);
            $function_nev .= $list === true ? ' lista' : ' szerkesztés';
            $function_azon = mysql_real_escape_string($moduleData['modul_function_azon']);
            $function_azon .= $list === true ? '' : 'edit';
            $query = "INSERT INTO modul_function (site_tipus_id, modul_azon, modul_function_azon, modul_function_nev, modul_function_tipus, modul_function_root, modul_function_torolt)
                      VALUES (1, 
                              '".mysql_real_escape_string($moduleData['modul_azon'])."', 
                              '{$function_azon}', 
                              '{$function_nev}', 
                              '__loadController', 
                              0, 
                              0)";
            return $this->_DB->prepare($query)->query_insert();
        }
        catch(Exception_MYSQL_Null_Affected_Rows $e){
            throw new Exception_MYSQL('A modul funkció regisztrálása sikertelen volt!');
        }
        catch(Exception_MYSQL $e){
            throw new Exception_MYSQL($e->getMessage());
        }
    }
    
    /**
     * Hozzárendeli a modul funkciót a "Root" jogcsoporthoz.
     * @param int $function_id
     * @throws Exception_MYSQL
     */
    public function registerRootRight($function_id)
    {
        try
        {
            $query = "INSERT INTO jogcsoport_function (jogcsoport_id, jogcsoport_function_id) VALUES (1, ".(int)$function_id.")";
            $this->_DB->prepare($query)->query_insert();
        }
        catch(Exception_MYSQL $e)
        {
            throw new Exception_MYSQL('A modul funkciót nem sikerült hozzárendelni a jogcsoporthoz!');
        }
    }
    
    public function loadRights($user_id) {
        $query = "
            SELECT user_jogcsoport_id 
            FROM user_jogcsoport 
            INNER JOIN jogcsoport 
                ON jogcsoport_id=user_jogcsoport_id AND 
                   jogcsoport_aktiv=1 AND 
                   jogcsoport_torolt=0 AND 
                   site_tipus_id=".Rimo::$_config->SITE_TIPUS."
            WHERE user_id={$user_id}
        ";
        $object = $this->_DB->prepare($query)->query_select();
        $list["rigths_where"] = " ( ";
        $list["jogcsoport_where"] = " ( ";
        while ($jogcsoport_id = $object->query_fetch_array("user_jogcsoport_id")) {
            $list["jogcsoport_where"] .= " jogcsoport_id={$jogcsoport_id} OR ";
            $list["jogcsoport"][$jogcsoport_id] = $jogcsoport_id;
            try{
                $query = "
                    SELECT modul_azon,
                           modul_function_azon,
                           modul_function_tipus,
                           modul_function_id
                    FROM jogcsoport_function 
                    INNER JOIN modul_function 
                   	    ON modul_function_id=jogcsoport_function_id AND modul_function_torolt=0	 
                    WHERE jogcsoport_id={$jogcsoport_id}
                ";
                $obj_jog = $this->_DB->prepare($query)->query_select();
                while($jog = $obj_jog->query_fetch_array()){
                    $list[$jog["modul_function_tipus"]][$jog["modul_azon"]][$jog["modul_function_azon"]] = true;
                    $list["rigths_where"] .= " modul_function_id={$jog["modul_function_id"]} OR ";
                    $list["jog"][] = $jog["modul_function_id"];
                }
            }
            catch(Exception_MYSQL_Null_Rows $e){
            }
        }
        $list["rigths_where"] .= " modul_function_id=0 )";
        $list["jogcsoport_where"] .= " jogcsoport_id=0 )";
        return $list;
    }
    
    /**
     * Legenerálja a modulhoz tartozó táblát. 
     * @param string $tablename => A modulhoz, vagy modelhez tartozó tábla neve.
     */
    public function createTable($tablename){
        $tablename = mysql_real_escape_string($tablename);
        $query = "CREATE  TABLE --MODUL-- (
                  --MODUL--_id INT(11) NOT NULL AUTO_INCREMENT ,
                  nyelv_id INT(11) NOT NULL ,
                  --MODUL--_nev VARCHAR(255) NOT NULL ,
                  --MODUL--_letrehozo INT(11) NOT NULL ,
                  --MODUL--_modosito INT(11) NOT NULL DEFAULT 0 ,
                  --MODUL--_javitas_szama INT(11) NOT NULL DEFAULT 0 ,
                  --MODUL--_letrehozas_datum DATETIME NOT NULL ,
                  --MODUL--_modositas_datum DATETIME NOT NULL DEFAULT '0000-00-00' ,
                  --MODUL--_aktiv TINYINT(1) NOT NULL DEFAULT 1 ,
                  --MODUL--_torolt TINYINT(1) NOT NULL DEFAULT 0 ,";
        if($this->createRows())
        {
            $query .= $this->rows2SQL($_POST['Fields']);
        }
        $query .= "PRIMARY KEY (--MODUL--_id) )
                   ENGINE = InnoDB";
        $query = str_replace('--MODUL--', $tablename, $query);
        //return $query;
        $this->_DB->prepare($query)->query_execute();
    }
    
    /**
     * Törli a paraméterül adott táblát.
     * @param string $table => A tábla neve, amit törölni kell.
     */
    public function rollbackTable($table){
        $query = "DROP TABLE IF EXISTS ".mysql_real_escape_string($table);
        $this->_DB->prepare($query)->query_execute();
    }
    
    /**
     * Megvizsgálja, hogy az adott modul fel lett-e véve az adatbázisba.
     * @param string $modulename => A modul neve.
     * @throws Exception_MYSQL
     */
    public function moduleExists($modulname){
        try{
            $query = "SELECT modul.modul_azon AS ModulID 
                      FROM modul_function 
                      INNER JOIN modul ON (modul.modul_azon = modul_function.modul_azon) 
                      WHERE modul_function.modul_azon LIKE '".mysql_real_escape_string($modulname)."'";
            $this->_DB->prepare($query)->query_select()->query_result_array();
            return true;
        }
        catch(Exception_MYSQL_Null_Rows $e){
            return false;
        }
        catch(Exception_MYSQL $e){
            return false;
        }
    }
    /*
    'Name' => 'Mező', // Mező neve, ahogy az adatbázisban szerepel majd.
    'Type' => 'VARCHAR', // Mező típusa, ahogy az adatbázisban szerepel majd.
    'Length' => 255, // Mező maximális hossza.
    'NotNull' => true, // Lehet-e NULL.
    'Default' => 0, // Alapértelmezett érték.
    'Fieldname' => 'MyField', // Mező neve, ahogy az űrlapon és az "Item"-ek között szerepel majd.
    'Fieldlabel' => 'Az én input mezőm', // Mező "olvasható" neve.
    'Fieldtype' => 'text', // Mező típusa. Ezt kapja majd prefixül.
    'Fieldrequired' => true, // Kötelező-e kitölteni a mezőt.
    'addForm' => true, // Adja-e hozzá az addFormhoz.
    'listField' => true, // Listázza-e az adott mezőt.
    */
    
    /**
     * A paraméterül adott tömbből legenerálja a CREATE TABLE Query kiegészítését.
     * @param array $data => A mezők adatait tartalmazó tömb.
     * @return string
     */
    public function rows2SQL($data)
    {
        $str = '';
        foreach($data as $item)
        {
            $str .= '--MODUL--_'.mysql_real_escape_string($item['Name']).' '.mysql_real_escape_string($item['Type']);
            if((int)$item['Length'] > 0)
            {
                $str .= '('.$item['Length'].')';
            }
            if($item['NotNull'] == 1)
            {
                $str .= ' NOT NULL';
            }
            if(isset($item['Default'][0]))
            {
                $str .= ' DEFAULT \''.mysql_real_escape_string($item['Default']).'\'';
            }
            $str .= ', ';
        }
        return $str;
    }
    
    /**
     * A paraméterül adott tömbből elkészíti a mező "addForm" metódusába tartozó sort.
     * @param array $field => A mező adatait tartalmazó tömb.
     * @return mixed(false|string)
     * @throws Exception_Module_Create
     */
    protected function field2addForm(array $field)
    {
        $fprefix = $this->getTypePrefix($field['Fieldtype']); // Prefix megállapítása a mező típusa alapján.
        if($fprefix) // Ha van prefix.
        {
            $str = '';
            if((int)$field['addForm'] == 1 || (int)$field['Fieldrequired'] == 1)
            {
                $rule = $this->getValidationRule($field['Fieldtype']); // Validációs szabály megállapítása a mező típusa alapján.
                if(!$rule)
                {
                    throw new Exception_Module_Create('A fájl generálása sikertelen volt, mert nem megfelelő adat érkezett!'); // Ha nem találja a típust, akkor kivételt dob.
                }
                $lname = strtolower($field['Name']); // Változó neve.
                $str .= '$'.$lname.' = $this->addItem(\''.$fprefix.$field['Fieldname'].'\');'."\n\t\t";
                if((int)$field['Fieldrequired'] == 1)
                {
                    $str .= '$'.$lname.'->_verify[\''.$rule.'\'] = true;'."\n\t\t";
                }
            }
            else
            {
                $str = false;
            }
            return $str;
        }
        else
        {
            throw new Exception_Module_Create('A fájl generálása sikertelen volt, mert nem megfelelő adat érkezett!'); // Ha nincs, akkor Exception-t dob.
        }
    }
    
    /**
     * A paraméterül adott tömbből elkészíti a mező "_bindArray" tömbbe kerülő elemét.
     * @param array $field => A mező adatait tartalmazó tömb.
     * @param string $prefix => A mező prefixe. (Tábla neve)
     * @return string
     * @throws Exception_Module_Create
     */
    protected function field2bindArray(array $field, $prefix)
    {
        $fprefix = $this->getTypePrefix($field['Fieldtype']); // Prefix megállapítása a mező típusa alapján.
        if($fprefix) // Ha van prefix...
        {
            return '\''.$prefix.'_'.$field['Name'].'\' => \''.$fprefix.$field['Fieldname'].'\','."\n\t\t"; // ...akkor visszatér a megfelelő stringgel.
        }
        else
        {
            throw new Exception_Module_Create('A fájl generálása sikertelen volt, mert nem megfelelő adat érkezett!'); // Ha nincs, akkor pedig kivételt dob.
        }
    }
    
    /**
     * A paraméterül adott tömbből elkészíti a mező "_fields" példányváltozójába tartozó sort. Ha erre mégsincs szükség, akkor false-szal tér vissza.
     * @param array $field => A mező adatait tartalmazó tömb.
     * @param string $prefix => A mező prefixe. (Tábla neve)
     * @return mixed(false|string)
     */
    protected function field2Fields(array $field, $prefix)
    {
        $str = '';
        if((int)$field['listField'] == 1)
        {
            $str .= $prefix.'_'.$field['Name'].' AS '.$field['Fieldname'].','."\n\t\t\t\t\t\t";
        }
        else
        {
            $str = false;
        }
        return $str;
    }
    
    /**
     * A paraméterül adott tömbből elkészíti a mező "tableHeader" példányváltozójába tartozó sort.
     * @param array $field => A mező adatait tartalmazó tömb.
     * @param string $prefix => A mező prefixe. (Tábla neve)
     * @return string
     */
    protected function field2tableHeader(array $field, $prefix)
    {
        return '\''.$prefix.'_'.$field['Name'].'\' => array(\'label\' => \''.$field['Fieldlabel'].'\'),'."\n\t\t\t";
    }
    
    protected function field2column(array $field)
    {
        return '<td class="align_left center">{$lista.'.$field['Fieldname'].'}</td>'."\n\t\t\t\t\t";
    }
    
    /**
     * Feldolgozza mezőket, majd visszatér egy tömbbel.
     * @param array $fields => A mezőket tartalmazó tömb.
     * @param string $fprefix => A mezőkhöz tartozó prefix.
     * @return string
     */
    public function getFieldsProcessed(array $fields, $fprefix)
    {
        if($this->createRows())
        {
            $fieldsArray = array(
                'addForm' => '', // Az addForm metódusba tartozó string kerül ide.
                'bindArray' => '', // A _bindArray példányváltozóba tartozó string kerül ide.
                'fields' => '', // A _fields példányváltozóba tartozó string kerül ide.
                'tableHeader' => '', // A tableHeader példányváltozóba tartozó string kerül ide.
                'inputHTML' => '', // Az Edit nézethez tartozó HTML kód kerül ide.
                //'SQL' => '',
                'columns' => '', // A List nézethez tartozó HTML kód kerül ide.
            );
            foreach($fields as $field)
            {
                $af = $this->field2addForm($field); // Az "addForm" visszatérési értékét tárolja.
                if($af) // Ha van visszatérési értéke a metódusnak.
                {
                    $fieldsArray['addForm'] .= $af; // Akkor hozzá konkatenálja a stringet az addForm attribútumhoz.
                    $fieldsArray['bindArray'] .= $this->field2bindArray($field, $fprefix); // Valamint a bindArray-hez is.
                }
                $ff = $this->field2Fields($field, $fprefix); // A "fields" visszatérési értékét tárolja.
                if($ff) // Ha van visszatérési értéke a metódusnak.
                {
                    $fieldsArray['fields'] .= $ff; // Akkor hozzákonkatenálja a stringet a fields attribútumhoz.
                    $fieldsArray['tableHeader'] .= $this->field2tableHeader($field, $fprefix); // A tableHeader-be is bekerül...
                    $fieldsArray['columns'] .= $this->field2column($field); // ...valamint a List view-hoz is.
                }
                $fieldsArray['inputHTML'] .= $this->getInputcode($field)."\n\n\t\t\t"; // Hozzáadás az Edit view-hoz.
            }
            return $fieldsArray;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * A mező adatai alapján legenerálja a mező input (Edit view) kódját.
     * @param array $data => A mező adatait tartalmazó tömb.
     * @return string
     * @throws Exception_Module_Create
     */
    protected function getInputcode(array $data)
    {
        $filename = self::INPUT_ROOT.'/'.$data['Fieldtype'].'input.php'; // Összeállítja a típushoz tartozó template nevét.
        if(file_exists($filename)) // Megvizsgálja, hogy létezik-e a fájl.
        {
            $content = file_get_contents($filename); // Kiolvassa a fájl tartalmát.
            if(!$data['Fieldrequired']) // Ha nem kötelező a mező...
            {
                $content = str_replace(' <span class="require">*</span>', '', $content); // ...akkor eltünteti a kötelezőséget jelölő *-ot.
            }
            $str = str_replace('Inputname', $data['Fieldname'], $content); // Input mező nevének cseréje.
            $str = str_replace('Inputlabel', $data['Fieldlabel'], $str); // Input label-jének cseréje.
            return $str;
        }
        else
        {
            throw new Exception_Module_Create('Hiba a fájl létrehozása során!'); // Ha nem, akkor kivételt dob.
        }
    }
    
    /**
     * Mező típusa alapján "megkeresi" a hozzá tartozó prefixet, majd visszatér vele. Ha nincs, akkor false-szal tér vissza.
     * @param string $fieldtype => A mező típusa.
     * @return mixed(false|string)
     */
    protected function getTypePrefix($fieldtype)
    {
        $prfs = Rimo::$_config->TYPE_PREFIXES;
        if(isset($prfs[$fieldtype]))
        {
            return $prfs[$fieldtype];
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Mező típusa alapján "megkeresi" a hozzá tartozó validációs szabályt, majd visszatér vele. Ha nincs, akkor false-szal tér vissza.
     * @param string $fieldtype => A mező típusa.
     * @return mixed(false|string)
     */
    protected function getValidationRule($fieldtype)
    {
        $rules = Rimo::$_config->VALIDATION_RULES;
        if(isset($rules[$fieldtype]))
        {
            return $rules[$fieldtype];
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Visszatér a használni kívánt scriptek elérési útját tartalmazó stringgel.
     * @return string
     * @throws Exception_Module_Create
     */
    public function getRequiredScripts()
    {
        // ChkSheepit, ChkTinyMCE
        $scriptParams = array('ChkSheepit', 'ChkTinyMCE', 'ChkprettyPhoto');
        $str .= '';
        foreach($scriptParams as $param)
        {
            if((int)$this->_params[$param]->_value === 1)
            {
                $script = $this->getScriptSrcByKey(str_replace('Chk', '', $param));
                if($script)
                {
                    $str .= $script."\n";
                }
                else
                {
                    throw new Exception_Module_Create('Bocsi, de a használni kívánt script kódja sajnos nincs meg! :/');
                }
            }
        }
        return $str;
    }
    
    /**
     * A script neve alapján "megkeresi" a hozzá tartozó elérési utat, majd visszatér vele. Ha nincs, akkor false-szal tér vissza.
     * @param string $fieldtype => A mező típusa.
     * @return mixed(false|string)
     */
    protected function getScriptSrcByKey($key)
    {
        $srcs = Rimo::$_config->SCRIPTS;
        $key = strtolower($key);
        if(isset($srcs[$key]))
        {
            return $srcs[$key];
        }
        else
        {
            return false;
        }
    }
    
    protected function createRows()
    {
        return isset($_POST['Fields'][0]['Name'][2]);
    }

}
?>