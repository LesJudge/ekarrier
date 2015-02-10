<?php
class User_Emlekezteto_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
        $email = $this->addItem("TxtEmail");
		$email->_verify["string"] = true;
		$email->_verify["email"] = true;
    }
    
    public function getUser(){
        $query = "
            SELECT user_id,
				   user_fnev,
				   user_vnev,
				   user_knev,
				   user_email
            FROM user
            WHERE user_email='".mysql_real_escape_string($this->_params["TxtEmail"]->_value)."' AND  
				  user_torolt=0
            LIMIT 1
        ";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    
    public function updateUserPW($user_id, $pw){
    	$query = "
    		UPDATE user
    		SET user_jelszo='".Create::passwordGenerator($pw, Rimo::$_config->SALT)."' 
    		WHERE user_id={$user_id}
    		LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
    }
}
?>