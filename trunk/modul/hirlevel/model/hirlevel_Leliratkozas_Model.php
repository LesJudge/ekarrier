<?php
class Hirlevel_Leliratkozas_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function hirlevelLeiratkozas($user_id){
        $query = "
            UPDATE hirlevel_user 
            SET hirlevel_user_leiratkozva=1,
                hirlevel_user_leiratkozas=now()
            WHERE MD5(hirlevel_user_id)='".mysql_real_escape_string($user_id)."' 
            LIMIT 1 
        ";
        $this->_DB->prepare($query)->query_update();
    }
}
?>