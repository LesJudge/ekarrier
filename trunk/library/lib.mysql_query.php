<?php
include_once "lib.exception.php";
/**
 * MYSQL lekérdezéseket kezelő osztály.
 * 
 * @package FrameWork
 * @subpackage MYSQL
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class MYSQL_Query {
    /**
     * @var resource Adatbázis erőforrás.
     */
    private $dbResource;
    private $query;
    private $result = null;
    
    /**
     * @var int A beszúrt sor azonosítója ({@link mysql_insert_id()}).
     */
    public $insert_id = null;
    /**
     * @var int A beszúrt sor azonosítója ({@link mysql_num_rows()}).
     */
    public $num_rows = null;
    public $affected_rows = null;

    /**
     * Beállítja az osztály számára a lekérdezést és az adatbázis erőforrást.
     * 
     * @param MYSQL_DB $db_resource
     * @param string $query
     */
    public function __construct( $db_resource, $query) {
        $this->dbResource = $db_resource;
        $this->query = $query;
    }

    /**
     * Alaphelyzetbe állítja az osztály változóit.
     * 
     */
    public function query_reset_variables() {
        if($this->result)
            mysql_free_result($this->result);
        $this->result = null;
        $this->insert_id = null;
        $this->num_rows = null;
        $this->affected_rows = null;
    }

    /**
     * A lekérdezésben elhelyezett változók cseréi.
     * 
     * A kapott tömb indexe nevű változót lecseréli a tömb[index] értékre.
     * <code>
     *      str_replace(":$index", mysql_real_escape_string($value) . " ' ", $this->query);
     * </code>
     * 
     * @param $binds {@link func_get_args()}
     */
    public function query_set_parameter() {
        $binds = func_get_args();
        foreach ($binds as $index => $value) {
            $this->query = str_replace(":$index", mysql_real_escape_string($value) . " ' ", $this->query);
        }
    }

    /**
     * A lekérdezés végrehajtása.
     * 
     * @uses Exception_MYSQL::Create_Error()
     * @throw Exception_MYSQL A hibakódtól {@link mysql_error()}</code> függően ennek leszármazottai
     * 
     */
    public function query_execute() {
        $this->query_reset_variables();
        $this->result = mysql_query($this->query);
        if (mysql_errno()) {
            throw Exception_MYSQL::Create_Error("<strong>MYSQL ERROR:</strong><br><br>{$this->query}<br><br>", mysql_error());
        }
    }

    /**
     * Select lekérdezés végrehajtása.
     * Beállításra kerül a lekérdezés eredményéül kapott sorok száma: MYSQL_Query::$num_rows
     * 
     * @uses MYSQL_Query::query_execute()
     * @uses Exception_MYSQL::Create_Error()
     * @throw Exception_MYSQL_Null_Rows
     * 
     * @return MYSQL_Query
     */
    public function query_select() {
        $this->query_execute();
        if (($this->num_rows = @mysql_num_rows($this->result)) == 0) {
            throw Exception_MYSQL::Create_Error("MYSQL Null Rows", 'null_rows');
        }
        return $this;
    }

    /**
     * Update lekérdezés végrehajtása.
     * Beállításra kerül a módosított sorok száma: MYSQL_Query::$affected_rows
     * 
     * @uses MYSQL_Query::query_execute()
     * @uses Exception_MYSQL::Create_Error()
     * @throw Exception_MYSQL_Null_Affected_Rows
     * 
     */
    public function query_update() {
        $this->query_execute();
        $this->affected_rows = mysql_affected_rows($this->dbResource);
        if($this->affected_rows==0){
            throw Exception_MYSQL::Create_Error("MYSQL Null Affected Rows", 'null_affected_row');
        }
    }

    /**
     * Insert lekérdezés végrehajtása.
     * Beállításara kerül a beszúrt sor egyedi azonosítója: MYSQL_Query::$insert_id
     * 
     * @return MYSQL_Query::$insert_id
     */
    public function query_insert() {
        $this->query_execute();
        $this->insert_id = mysql_insert_id($this->dbResource);
        return $this->insert_id;
    }

    /**
     * Fetch array végrehajtása
     * 
     * @param string A mysql_fetch_array() tömb kulcsa.
     * 
     * @return array|mixed|false
     */
    public function query_fetch_array($var = false) {
        $value = mysql_fetch_array($this->result);
        if($var){
            return $value[$var];
        }
        return $value;
    }

    /**
     * Tömbbként visszaadja a lekérdezés eredményéül kapott rekordokat. Visszatérési értéke vagy egy üres tömb, vagy egy adatokkal feltöltött tömb.
     * 
     * @uses MYSQL_Query::query_fetch_array()
     * 
     * @return array
     */
    public function query_result_array() {
        //$result_array = array();
        $index = 0;
        while (($row = $this->query_fetch_array()) !== false) {
            $result_array[$index] = $row;
            $index++;
        }
        return $result_array;
    }

}
?>