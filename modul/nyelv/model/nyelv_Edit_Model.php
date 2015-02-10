<?php
class Nyelv_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "nyelv";
    public $_bindArray = array("nyelv_nev" => "TxtNev", "nyelv_azon" => "TxtAzon",  "nyelv_aktiv" => "ChkAktiv");
    
    public function __addForm(){
        parent::__addForm();
        $this->addItem("TxtNev")->_verify["string"] = true;
        
        $azon = $this->addItem("TxtAzon");
        $azon->_verify["string"] = true;
        $azon->_verify["unique"] = array("table" => "nyelv", "field"=>"nyelv_azon", "modify"=>$this->modifyID, "DB"=>$this->_DB);
         
        $file = $this->addItem("File");
        $file->_action_type = &$_FILES;
        $file->_verify["maxsize"] = 4194300;       
        $file->_verify["picture"] = true; 
    }
    
    public function deleteKep($file_name){
        $query = "
            UPDATE {$this->_tableName} SET nyelv_zaszlo_nev='' 
            WHERE nyelv_id='{$this->modifyID}'
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
        @unlink("modul/".Rimo::$_config->APP_PATH."/upload/" . $file_name);
    }
    
    public function __editData(){
        $query = "
            SELECT nyelv_zaszlo_nev
            FROM {$this->_tableName}
            WHERE nyelv_id='{$this->modifyID}'
            LIMIT 1
        ";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    
    public function __update(){
        parent::__update(",nyelv_zaszlo_nev=".Create::upload_file($this->_params["File"]->_value, "nyelv_zaszlo_nev"));    
    }
    
    public function __insert(){
        parent::__insert(",nyelv_zaszlo_nev=".Create::upload_file($this->_params["File"]->_value, "nyelv_zaszlo_nev"));
        $this->createHirlevelCsoport($this->insertID);
    }
    
    private function createHirlevelCsoport($id){
    	try{
    		$query = "
    			SELECT hirlevel_csoport_tipus,
    				   hirlevel_csoport_nev 	
    			FROM hirlevel_csoport 
    			WHERE 	hirlevel_csoport_tipus_nyelv>0
    			GROUP BY hirlevel_csoport_tipus
			";
			$obj = $this->_DB->prepare($query)->query_select();
			while($row = $obj->query_fetch_array()){
				$query = "
					INSERT INTO hirlevel_csoport 
					SET 
						hirlevel_csoport_nev='{$row["hirlevel_csoport_nev"]}',	
						hirlevel_csoport_nyelv_id={$id},
						hirlevel_csoport_tipus='{$row["hirlevel_csoport_tipus"]}',
						hirlevel_csoport_tipus_nyelv={$id}
				";
				$this->_DB->prepare($query)->query_insert();
			}
    	}
    	catch(Exception_MYSQL $e){
    	}
    }
}
?>