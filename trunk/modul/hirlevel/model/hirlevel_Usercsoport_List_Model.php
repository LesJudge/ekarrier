<?php
class Hirlevel_Usercsoport_List_Model extends Admin_List_Model {
    public $_tableName = "hirlevel_csoport";
    public $_fields = "hirlevel_csoport_id AS ID, hirlevel_csoport_nev AS elso, nyelv_nev";
    public $tableHeader = array(
            "hirlevel_csoport_nev" => array("label" => "Név", "width" => 85),
            "nyelv_nev" => array("label" => "Kapcsolat nyelve", "width" => 15)
    );
    public $_join= "INNER JOIN nyelv ON nyelv_id=hirlevel_csoport_nyelv_id AND nyelv_torolt=0";
    
    
    public function csoportTorolheto($id){
    	try{
    		$query = "
    			SELECT hirlevel_csoport_id
    			FROM hirlevel_csoport
    			WHERE hirlevel_csoport_tipus_nyelv>0 AND 
					  hirlevel_csoport_id=".mysql_real_escape_string($id)." 
				LIMIT 1 	
			";
			$this->_DB->prepare($query)->query_select()->query_fetch_array("hirlevel_csoport_id");
			return false;
   		}
   		catch(Exception_MYSQL_Null_Rows $e){
   			return true;
   		}
    }
}
?>