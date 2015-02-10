<?php
class User_Megerosites_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function megerosites($user_id){
        $query = "
            UPDATE user 
            SET user_megerositve_date=now(),
                user_megerositve=1
            WHERE MD5(user_id)='".mysql_real_escape_string($user_id)."' 
            LIMIT 1 
        ";
        $this->_DB->prepare($query)->query_update();
    }
}
?>