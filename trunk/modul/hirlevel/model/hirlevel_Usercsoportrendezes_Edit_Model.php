<?php
class Hirlevel_Usercsoportrendezes_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "hirlevel_user_attr_csoport";
    
    public function __formValues(){
        $query = "
            SELECT hirlevel_csoport_id
            FROM hirlevel_csoport
            WHERE hirlevel_csoport_id={$this->modifyID} AND 
                  hirlevel_csoport_torolt=0
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_select($query);
        $this->_params["SelUser"]->_value = $this->getCsoportSzemelyek();  
    }
    
    public function __addForm(){
    	$csoport = $this->addItem("SelCsoport");
		$csoport->_select_value = $this->csoportSelect();
		$this->addItem("SelUser")->_select_value = $this->getSzemelyekSelect($where);
    }
    
    private function csoportSelect(){
    	try{
            $list = array(0=>"--Szűkítsen csoport alapján--");
            $query = "
                SELECT hirlevel_csoport_id,
					   CONCAT(hirlevel_csoport_nev,' (',nyelv_nev,') ') AS nev 
                FROM hirlevel_csoport 
                INNER JOIN nyelv ON nyelv_id=hirlevel_csoport_nyelv_id 	
                WHERE hirlevel_csoport_torolt=0 
                ORDER BY hirlevel_csoport_nyelv_id ASC,  
                	     hirlevel_csoport_tipus DESC,
						 hirlevel_csoport_nev ASC
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while($adat = $obj->query_fetch_array()){
                $list[$adat["hirlevel_csoport_id"]] = $adat["nev"];
            }
            return $list;
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
    
    public function __update(){
        $this->saveCsoportSzemely();
    }
    
    public function __editData(){
    	if($this->_params["SelCsoport"]->_value>0)
			$where = " AND (hirlevel_user_attr_csoport_id={$this->_params["SelCsoport"]->_value} OR hirlevel_user_attr_csoport_id={$this->modifyID})";
        $this->_params["SelUser"]->_select_value = $this->getSzemelyekSelect($where);
        $query = "
            SELECT hirlevel_csoport_nev,
                   nyelv_nev
            FROM hirlevel_csoport
            INNER JOIN nyelv ON nyelv_id=hirlevel_csoport_nyelv_id AND nyelv_torolt=0
            WHERE hirlevel_csoport_id='{$this->modifyID}' 
            LIMIT 1
        ";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    
    private function getCsoportSzemelyek(){
        try{
            $query = "
                SELECT hirlevel_user_id
                FROM hirlevel_user_attr_csoport
                WHERE hirlevel_user_attr_csoport_id={$this->modifyID} 
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while($adat = $obj->query_fetch_array("hirlevel_user_id")){
                $list[$adat] = $adat;
            }
            return $list;
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
    
    private function getSzemelyekSelect($where){
    	try{
            $query = "
                SELECT hirlevel_user.hirlevel_user_id AS id,
					   CONCAT(hirlevel_user_nev,' - ',hirlevel_user_email) AS nev
                FROM hirlevel_user
                LEFT JOIN hirlevel_user_attr_csoport ON hirlevel_user.hirlevel_user_id=hirlevel_user_attr_csoport.hirlevel_user_id
                WHERE hirlevel_user_leiratkozva=0 AND 
					 hirlevel_user_torolt=0
					 {$where} 
			    GROUP BY hirlevel_user.hirlevel_user_id 
			    ORDER BY hirlevel_user_nev
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while($adat = $obj->query_fetch_array()){
                $list[$adat["id"]] = $adat["nev"];
            }
            return $list;
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
    
    private function saveCsoportSzemely(){
        try{
            $this->_DB->prepare("DELETE FROM hirlevel_user_attr_csoport WHERE hirlevel_user_attr_csoport_id={$this->modifyID}")->query_execute();
        }catch(Exception_MYSQL $e){
        }
        if(is_array($this->_params["SelUser"]->_value)){
            foreach($this->_params["SelUser"]->_value as $val){
                $query = "
                INSERT INTO hirlevel_user_attr_csoport
                SET 
                    hirlevel_user_attr_csoport_id={$this->modifyID},
                    hirlevel_user_id=".mysql_real_escape_string($val);
                $this->_DB->prepare($query)->query_insert();
            }
        }
    }
}
?>