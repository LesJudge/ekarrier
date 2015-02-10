<?php

include_once "page/all/model/page.model.php";

/**
 * Elem szerkesztése, új felvitele
 * 
 * @package Global
 * @subpackage Model
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
abstract class Page_Edit_Model extends Page_Model {
    public $modifyID;
    public $insertID;

    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    /**
     * Módosító azonosító beállítása
     * 
     * @param mixed $val
     */
    public function __setModifyID($val) {
        $val = mysql_real_escape_string($val);
        if ($val>0) {
            $this->modifyID = $val;
        }
    }

    /**
     * Sor betöltés query generálása és végrehajtása. Ezeket az értékeket beállítja a form elemeknek. 
     * 
     * @uses Model::getItemValue()
     * @uses Create::query_load_sets()
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_select()
     * @uses MYSQL_Query::query_fetch_array()
     */
    public function __formValues() {
        $query = sprintf("
            SELECT " . Create::query_load_sets($this->_bindArray) . " 
            FROM  %s
            WHERE %s_id=%d  
            ", $this->_tableName, $this->_tableName, $this->modifyID);
        if ($this->nyelvID) $query .= " AND nyelv_id={$this->nyelvID}";
        $query .= " LIMIT 1 ";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        foreach ($this->_bindArray as $field => $item) {
            $this->getItemObject($item, "loadData")->_value = $data[$field];
        }
    }

    /**
     * Sor beszúrás query generálása és végrehajtása.
     * 
     * @param string $sets Query-hez hozzáfűzés. Vesszővel kezd!!
     * 
     * @uses Create::query_set_sets()
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_insert()
     *
     * @return insert_id
     */
    public function __insert($sets="") {
        foreach ($this->_bindArray as $field => $item) {
            $data[$field] = $this->getItemValue($item, "onClick_New");
        }
        $query = "
            INSERT INTO `{$this->_tableName}`  
            SET     
                " . Create::query_set_sets($data). $sets . "  
        ";
        if ($this->nyelvID) $query .= " ,nyelv_id={$this->nyelvID}";
        if($this->modifyID)  $query .= " ,{$this->_tableName}_id={$this->modifyID}";
        $this->insertID = $this->_DB->prepare($query)->query_insert();
        
    }

    /**
     * Sor módosítás query generálása és végrehajtása.
     * 
     * @param string $sets Query-hez hozzáfűzés. Vesszővel kezd!!
     * 
     * @uses Create::query_set_sets()
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_update()
     */
    public function __update($sets="") {
        foreach ($this->_bindArray as $field => $item) {
            $data[$field] = $this->getItemValue($item, "onClick_Modify");
        }
        $query =" 
             UPDATE `{$this->_tableName}`    
             SET
                " . Create::query_set_sets($data) . $sets . " 
             WHERE {$this->_tableName}_id={$this->modifyID} 
        ";
        if ($this->nyelvID) $query .= " AND nyelv_id={$this->nyelvID}";
        $query .= " LIMIT 1 ";
        $this->_DB->prepare($query)->query_update();
    }

    /**
     * Nyelvesített elemnél lekérdezzük, hogy van-e bármilyen nyelven már a módosítani kívánt elem.
     * 
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_select()
     * @uses MYSQL_Query::query_fetch_array()
     * 
     * @return mysql_fetch_array()
     */
    public function verifyRow($nyelv="") {
        $where = "";
        if ($nyelv) $where = " AND nyelv_id={$nyelv}";
        $query ="
            SELECT nyelv_id 
            FROM  $this->_tableName
            WHERE {$this->_tableName}_id={$this->modifyID}
                  {$where}
            LIMIT 1
        "; 
        return $this->_DB->prepare($query)->query_select()->query_fetch_array("nyelv_id");
    }

    /**
     * Új elem felvitelénél ez a függvény fut le
     * 
     */
    public function __newData() {
    }

    /**
     * Módosítás esetén mindig lefut.
     * 
     */
    public function __editData() {
        return array();
    }
    
    /**
     * Multiselect értékének mentése kapcsolódó táblába
     * 
     * @param string $join_table
     * @param mixed $input
     * @param string $id
     */
    public function saveSelect($join_table, $input, $id){
        try{
            $this->_DB->prepare("DELETE FROM {$join_table} WHERE {$this->_tableName}_id={$id}")->query_execute();
        }catch(Exception_MYSQL $e){
        }
        if(is_array($input)){
            foreach($input as $val){ 
                $query = "
                INSERT INTO {$join_table} 
                SET 
                    {$this->_tableName}_id={$id},
                    {$join_table}_id=".mysql_real_escape_string($val);
				$this->_DB->prepare($query)->query_insert();
            }
        }
    }
    
    /**
     * HTML select _value feltöltéséhez szükséges tömb.
     * 
     * @param string $join_table
     * @param string $where
     * @return array
     */
    public function getSelectAktivValues($join_table, $where=""){
        try
        {
            $query = "
                SELECT {$join_table}_id
                FROM {$join_table}
                WHERE {$this->_tableName}_id={$this->modifyID} 
                      {$where}
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while($adat = $obj->query_fetch_array("{$join_table}_id")){
                $list[$adat] = $adat;
            }
            return $list;
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
}
?>