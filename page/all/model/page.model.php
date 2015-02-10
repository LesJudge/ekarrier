<?php
include_once "library/lib.model.php";
abstract class Page_Model extends Model{
    public $nyelvID=false;
    
    public function __addForm() {
    }
    
     /**
     * Nyelv azonosító beállítása
     * 
     * @param mixed $val
     */
    public function __setNyelvID($val) {
        $val = mysql_real_escape_string($val);
        if ($val>0) {
            $this->nyelvID = $val;
        }
    }	
     /**
     * HTML select select_values feltöltéséhez szükséges tömb.
     * 
     * @param string $table
     * @param mixed $val_field
     * @param string $where
     * @param string $order
     * @param boolean $nyelvesitett
     * @param array $added_array
     * @return array
     */
    public function getSelectValues($table, $val_field, $where="", $order="", $nyelvesitett=true, $added_array=""){
        try
        {
            $list = $added_array;
            if($nyelvesitett){
                $where .= " AND nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID;
            }
            if($table==$this->_tableName AND $this->modifyID){
                $where .= " AND {$table}_id<>{$this->modifyID} ";
            }
            $query = "
                SELECT {$table}_id, {$val_field}
                FROM {$table}
                WHERE {$table}_torolt=0 
                      {$where} 
                {$order} 
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while($adat = $obj->query_fetch_array()){
                $list[$adat[$table."_id"]] = $adat[$val_field];
            }
            return $list;
        }catch(Exception_MYSQL_Null_Rows $e){
            if($added_array)
                return $added_array;
            return array();
        }
        catch(Exception_MYSQL $e){
            return array("0"=>"HIBA");
        }
    }
} 
?>