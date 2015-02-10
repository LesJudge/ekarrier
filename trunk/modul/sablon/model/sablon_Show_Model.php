<?php
class Sablon_Show_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function getSablon($id){
        $query = "
            SELECT sablon_tartalom
            FROM sablon 
            WHERE sablon_id=".mysql_real_escape_string($id)." 
            LIMIT 1
        ";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array("sablon_tartalom");
    }
}
?>