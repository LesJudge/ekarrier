<?php

include_once "page/all/model/page.model.php";

/**
 * Site-on a MYSQL alapú listák lekérdezései.
 * 
 * @package Global
 * @subpackage Model
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */  
abstract class Page_List_Model extends Page_Model {
    public $listWhere = array();
    public $_fields;
    public $_join;
    public $sortBY;
    public $limit;
    
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function __addForm(){
        $this->addItem("SelPagingLimit")->_select_value = array("10"=>"10","15"=>"15","25"=>"25","50"=>"50");
    }

    /**
     * Feltétel beállítása egy beviteli mezőből kapott értékkel.
     * 
     * @param string $feltetel
     * @param string $item
     */
    public function __setWhereInput($feltetel, $item) {
        $this->listWhere[$item] = "(".str_replace(":item", mysql_real_escape_string($this->getItemValue($item, "onClick_Filter :: setWhereInput")), $feltetel).")";     
    }
    
    /**
     * Lekérdezés feltétel összerakása.
     * 
     * @return void
     */
    public function __createWhere(){
        $felt_array = "{$this->_tableName}_torolt=0 AND " . implode(" AND ", $this->listWhere);
        $this->listWhere = " WHERE {$felt_array}";
    }
    
    /**
     * Lista betöltés query generálása és végrehajtása.
     * 
     * 
     * @uses Create::query_list_load()
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_select()
     * @uses MYSQL_Query::query_result_array()
     * 
     * @return result_array
     */
    public function __loadList() {
        if(!empty($this->sortBY)){
            $order = " ORDER BY {$this->sortBY}";
        } 
        $query =  "SELECT {$this->_fields} FROM `{$this->_tableName}` {$this->_join} {$this->listWhere} GROUP BY `{$this->_tableName}`.{$this->_tableName}_id {$order} {$this->limit}";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    /**
     * Lista COUNT query-e és végrehajtása.
     *    
     * @param mixed $where
     * 
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_select()
     * @uses MYSQL_Query::query_fetch_array()
     * 
     * @return count
     */
    public function __loadListCount() {
        $this->__createWhere();
        $query = "SELECT COUNT(DISTINCT(`{$this->_tableName}`.{$this->_tableName}_id)) AS cnt FROM `{$this->_tableName}` {$this->_join} {$this->listWhere}";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array("cnt");
    }
}

?>