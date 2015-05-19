<?php
class user_Login_Model extends Model {
    public function __construct() {
        $this->addDB("MYSQL_DB");        
    }
  
    public function loginForm(){
        $this->addItem("TxtFnev")->_verify["string"] = true;
        $this->addItem("PassJelszo")->_verify["string"] = true;
    }
    /*
    public function login($name, $pw) {
        $pw = mysql_real_escape_string($pw);
        
             
        $query = sprintf("
            SELECT user_id, 
                   user_fnev, 
                   user_jelszo,
                   user_email,
                   user_aktiv,
                   user_torolt,
                   user_megerositve
            FROM user
           WHERE user_fnev='%s' AND 
                  user_jelszo='%s'", mysql_real_escape_string($name), Create::passwordGenerator($pw, Rimo::$_config->SALT));
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
*/
    
    public function login($name, $pw, $type) {
        $pw = mysql_real_escape_string($pw);
        
        if($type=="mv"){
            $join =" INNER JOIN user_ugyfel ON user_ugyfel.user_id = user.user_id ";
        }
        if($type=="ma"){
            $join = " INNER JOIN user_ceg ON user_ceg.user_id = user.user_id ";
        }
        
        $query = sprintf("
            SELECT user.user_id, 
                   user_fnev, 
                   user_jelszo,
                   user_email,
                   user_aktiv,
                   user_torolt,
                   user_last_login,
                   user_megerositve
            FROM user
            " . $join . "
            WHERE user_fnev='%s' AND 
                  user_jelszo='%s'", mysql_real_escape_string($name), Create::passwordGenerator($pw, Rimo::$_config->SALT));
        
        
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    
    public function loadUser($id) {
        $query = sprintf("
            SELECT user_id, 
                   user_fnev,
                   user_email,
                   /*user_vnev,
                   user_knev,*/
                   user_jelszo, 
                   user_email 
            FROM user 
            WHERE user_aktiv=1 AND 
                  user_torolt=0 AND   
                  user_id='%d' 
            LIMIT 1 ", mysql_real_escape_string($id));
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }

    public function loadRights($user_id) {
        $query = "
            SELECT user_jogcsoport_id 
            FROM user_jogcsoport 
            INNER JOIN jogcsoport 
                ON jogcsoport_id=user_jogcsoport_id AND 
                   jogcsoport_aktiv=1 AND 
                   jogcsoport_torolt=0 AND 
                   site_tipus_id=".Rimo::$_config->SITE_TIPUS."
            WHERE user_id={$user_id}
        ";
        $object = $this->_DB->prepare($query)->query_select();
        $list["rigths_where"] = " ( ";
        $list["jogcsoport_where"] = " ( ";
        while ($jogcsoport_id = $object->query_fetch_array("user_jogcsoport_id")) {
            $list["jogcsoport_where"] .= " jogcsoport_id={$jogcsoport_id} OR ";
            $list["jogcsoport"][$jogcsoport_id] = $jogcsoport_id;
            try{
                $query = "
                    SELECT modul_azon,
                           modul_function_azon,
                           modul_function_tipus,
                           modul_function_id
                    FROM jogcsoport_function 
                    INNER JOIN modul_function 
                   	    ON modul_function_id=jogcsoport_function_id AND modul_function_torolt=0	 
                    WHERE jogcsoport_id={$jogcsoport_id}
                ";
                $obj_jog = $this->_DB->prepare($query)->query_select();
                while($jog = $obj_jog->query_fetch_array()){
                    $list[$jog["modul_function_tipus"]][$jog["modul_azon"]][$jog["modul_function_azon"]] = true;
                    $list["rigths_where"] .= " modul_function_id={$jog["modul_function_id"]} OR ";
                    $list["jog"][] = $jog["modul_function_id"];
                }
            }
            catch(Exception_MYSQL_Null_Rows $e){
            }
        }
        $list["rigths_where"] .= " modul_function_id=0 )";
        $list["jogcsoport_where"] .= " jogcsoport_id=0 )";
        return $list;
    }   
    
    public function modifyUser($user_id){
        try{
            $query = "
                UPDATE user 
                SET user_last_login=now(),
                    user_szum_login=user_szum_login+1 
                WHERE user_id={$user_id} 
                LIMIT 1
            ";
            $this->_DB->prepare($query)->query_update();
        }catch(exception $e){
        }
    }  
    public static function loadUserData($user_id,$db){
		$query = sprintf("
            SELECT /*user_vnev, 
                   user_knev, */
                   user_email 
            FROM user 
            WHERE user_aktiv=1 AND 
                  user_torolt=0 AND   
                  user_id='%d' 
            LIMIT 1 ", mysql_real_escape_string($user_id));
        return $db->prepare($query)->query_select()->query_fetch_array();
	}    
}
?>