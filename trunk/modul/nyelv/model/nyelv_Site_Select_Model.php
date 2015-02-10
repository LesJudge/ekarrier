<?php
class nyelv_Site_Select_Model extends Model {
	public static $nyelvek=array();
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function getNyelvek($editor=false) {
        $var = Rimo::$_config->NYELV_VAR;
        $query = "
            SELECT 	nyelv_id, 
                    nyelv_zaszlo_nev,
                    nyelv_nev,
					nyelv_azon                   
            FROM nyelv
            WHERE nyelv_aktiv=1 AND 
                  nyelv_torolt=0  	
        ";
        $obj = $this->_DB->prepare($query)->query_select();
        while ($nyelv = $obj->query_fetch_array()) {
            if ($param == $nyelv["nyelv_id"])
                $nyelv["aktiv"] = true;
            $nyelv["nyelv_link"] = "?default_nyelv=".$nyelv["nyelv_id"];
            self::$nyelvek[$nyelv["nyelv_id"]] = $nyelv;
        }
        return self::$nyelvek;
    }
    
    
     public function modifyDefaultLang(){
        $var = Rimo::$_config->NYELV_VAR;
        
        if($_REQUEST["default_nyelv"]>0 AND array_key_exists($_REQUEST["default_nyelv"],self::$nyelvek)){
            $_SESSION["NYELV_ID"] = $_REQUEST["default_nyelv"];
        }
        elseif(!isset($_SESSION["NYELV_ID"])){
            $_SESSION["NYELV_ID"] = Rimo::$_config->$var;;
            
        }
        Rimo::$_config->$var = $_SESSION["NYELV_ID"]; 
    }
}

?>