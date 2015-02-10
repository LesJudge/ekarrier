<?php
class Hirlevel_Megnyitas_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function megnyitasSzamlalo($hirlevel_id, $user_id){
        $query = "
            UPDATE hirlevel_kikuldve 
            SET 
                hirlevel_kikuldve_megnyitva=1
            WHERE hirlevel_id=".mysql_real_escape_string($hirlevel_id)." AND 
                  MD5(hirlevel_user_id)='".mysql_real_escape_string($user_id)."' 
            LIMIT 1
        ";  
        $this->_DB->prepare($query)->query_update();
    }
    
    public function updateHirlevel($hirlevel_id){
        $query = "
            UPDATE hirlevel 
            SET 
                hirlevel_megnyitva=hirlevel_megnyitva+1
            WHERE hirlevel_id=".mysql_real_escape_string($hirlevel_id)." 
            LIMIT 1
        ";        
        $this->_DB->prepare($query)->query_update();
    }
}
?>