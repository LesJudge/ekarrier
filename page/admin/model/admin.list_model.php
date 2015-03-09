<?php
/**
 * Adminban a listához alap filter, rendezés, sorkiválasztás, elem/oldal itemek.
 * 
 * @package Admin
 * @subpackage Model
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */  
abstract class Admin_List_Model extends Page_List_Model {
    public $tableHeader;
    
    public function __addForm() {
        parent::__addForm();
        $this->addItem("FilterSzuro");
        $this->addItem("TxtSort");
        $this->addItem("SelRow")->_select_value = array();
    }  
    
    /**
     * Sor státusz módosítának query-e és végrehajtása 1|0.
     * 
     * @param mixed $field_postfix
     * @param int $row_id
     * 
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_update()
     */
    public function __modifyRowStatusz($field_postfix, $row_id) {
        $field_postfix = mysql_real_escape_string($field_postfix);
        $query = "
            UPDATE `{$this->_tableName}` 
            SET {$this->_tableName}_{$field_postfix}=IF({$this->_tableName}_{$field_postfix}=1,0,1)
            WHERE {$this->_tableName}_id=".mysql_real_escape_string($row_id);
        if ($this->nyelvID) $query .= " AND nyelv_id={$this->nyelvID}";
        $query .= " LIMIT 1 ";
        $this->_DB->prepare($query)->query_update();
    }
    
    /**
     * Sor státusz módosítának query-e és végrehajtása bármilyen értékre.
     * 
     * @param mixed $field_postfix
     * @param int $row_id
     * @param mixed $value
     * @param int nyelv_id
     * 
     * @uses MYSQL_DB::prepare()
     * @uses MYSQL_Query::query_update()
     */
    public function __modifyRowStatuszWithValue($field_postfix, $row_id, $value) {
        $query = "
            UPDATE `{$this->_tableName}` 
            SET {$this->_tableName}_{$field_postfix}='".mysql_real_escape_string($value)."'
            WHERE {$this->_tableName}_id=".mysql_real_escape_string($row_id);
        if ($this->nyelvID) $query .= " AND nyelv_id={$this->nyelvID}";
        $query .= " LIMIT 1 ";
        $this->_DB->prepare($query)->query_update();
    }
}