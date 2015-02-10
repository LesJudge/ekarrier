<?php
class nyelv_Admin_Select_Model extends Model {
	public $nyelvek=array();
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function getNyelvek($editor=false) {
        $var = Rimo::$_config->NYELV_VAR;
        $query = "
            SELECT 	nyelv_id, 
                    nyelv_zaszlo_nev,
                    nyelv_nev                   
            FROM nyelv
            WHERE nyelv_aktiv=1 AND 
                  nyelv_torolt=0  	
    	";
        $obj = $this->_DB->prepare($query)->query_select();
        $act_link = strtok($_SERVER["REQUEST_URI"], "?");
        if($editor){
            $link_var = "nyelv";
            $param = $_REQUEST["nyelv"];
        }
        else{ 
            $link_var = "default_nyelv";
            $param = Rimo::$_config->$var;
        }
        while ($nyelv = $obj->query_fetch_array()) {
            if ($param == $nyelv["nyelv_id"])
                $nyelv["aktiv"] = true;
            $nyelv["nyelv_link"] = $act_link."?".$link_var."=".$nyelv["nyelv_id"]; 
            $this->nyelvek[$nyelv["nyelv_id"]] = $nyelv;
        }
        return $this->nyelvek;
    }
    
    
    public function modifyDefaultLang(){
        $var = Rimo::$_config->NYELV_VAR;
        if($_REQUEST["default_nyelv"]>0 AND array_key_exists($_REQUEST["default_nyelv"],$this->nyelvek)){
            $_SESSION["NYELV_ID"] = $_REQUEST["default_nyelv"];
        }
        elseif(!isset($_SESSION["NYELV_ID"])){
            $_SESSION["NYELV_ID"] = Rimo::$_config->$var;;
        }
        Rimo::$_config->$var = $_SESSION["NYELV_ID"]; 
    }
}

?>