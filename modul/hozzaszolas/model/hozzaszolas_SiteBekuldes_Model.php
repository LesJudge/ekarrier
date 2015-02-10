<?php
class hozzaszolas_SiteBekuldes_Model extends Page_Edit_Model {

    public function __addForm(){
    	$this->_bindArray = array("hozzaszolas_nyelv" => "Nyelv", 
                               "hozzaszolas_bekuldo" => "TxtBekuldo", 
                               "hozzaszolas_tartalom" => "TxtTartalom",
        );
        parent::__addForm();
        $this->addItem("Nyelv");                
        $this->addItem("TxtBekuldo")->_verify["string"] = true;
        $this->addItem("TxtTartalom")->_verify["string"] = true;
        $this->addItem("SessCaptcha");
        
		$captcha = $this->addItem("TxtCaptcha");
		$captcha->_verify["string"] = true;
        $captcha->_verify["equalToCaptcha"] = $this->_params["SessCaptcha"];
    }   
    
    public function __insert(){
        $this->_params["TxtTartalom"]->_value = strip_tags($this->_params["TxtTartalom"]->_value);
    	$kapcsolodo_id = mysql_real_escape_string($_REQUEST["kapcs_id"]);
    	$parent_id = mysql_real_escape_string($_REQUEST["parent_id"]);
    	if($parent_id){
	        $this->insertChildNode($parent_id, $kapcsolodo_id, ",hozzaszolas_bekuldve_date=now(),kapcsolodo_id={$kapcsolodo_id}");
	    }
	    else{
	        $this->insertRootNode($kapcsolodo_id, ",hozzaszolas_bekuldve_date=now(),kapcsolodo_id={$kapcsolodo_id}");
	    }    
    }
    
    /**
     * Főkategória létrehozása
     */
    private function insertRootNode($kapcsolodo_id, $sets = "") {
        try {
            //$this->_DB->prepare("LOCK TABLES {$this->_tableName} WRITE")->query_execute();
            $query = "SELECT jobboldal FROM {$this->_tableName} WHERE kapcsolodo_id={$kapcsolodo_id} ORDER BY jobboldal DESC LIMIT 1";
            $last_right = $this->_DB->prepare($query)->query_select()->query_fetch_array("jobboldal");
            $lft = $last_right + 1;
            $rgt = $lft + 1;
        }
        catch (Exception_MYSQL_Null_Rows $e) {
            $lft = 1;
            $rgt = 2;
        }
        catch (Exception_MYSQL $e) {
        }
        parent::__insert("{$sets}, baloldal={$lft}, jobboldal={$rgt}, szint=0");
       // $this->_DB->prepare("UNLOCK TABLES")->query_execute();
    }

    /**
     * Új elem beszúrása esetén a fa újraépítése
     * @param integer $lft lft of parent node
     * @param integer $rgt	rgt of parent node
     */
    private function insertNode($kapcsolodo_id, $lft, $rgt, $level) {
        try {
            $query = "UPDATE {$this->_tableName} SET jobboldal = jobboldal + 2 WHERE kapcsolodo_id={$kapcsolodo_id} AND jobboldal >= {$rgt};";
            $this->_DB->prepare($query)->query_update();
            $query = "UPDATE {$this->_tableName} SET baloldal = baloldal + 2 WHERE kapcsolodo_id={$kapcsolodo_id} AND baloldal > {$rgt};";
            $this->_DB->prepare($query)->query_update();
        }
        catch (Exception_MYSQL_Null_Affected_Rows $e) {
        }
    }

    /**
     * Visszaadja az adott kategória oldal értékeit.
     */
    private function getNode($id) {
        $query = "
                SELECT {$this->_tableName}_id, 
                       baloldal, 
                       jobboldal,
                       szint
                FROM {$this->_tableName} 
                WHERE {$this->_tableName}_id = {$id} 
                LIMIT 1
        ";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }

    /**
     * Gyerek elem beszúrása
     */
    private function insertChildNode($parent, $kapcsolodo_id, $sets = "") {
        try {
            //$this->_DB->prepare("LOCK TABLES {$this->_tableName} WRITE")->query_execute();
            $parent_node = $this->getNode($parent);
            
            $lft = $parent_node["baloldal"];
            $rgt = $parent_node["jobboldal"];
            $szint = $parent_node["szint"];
            $this->insertNode($kapcsolodo_id, $lft, $rgt, $szint);
			$lft = $rgt;
        	$rgt = $rgt + 1;
        	$szint = $szint + 1;
			parent::__insert("{$sets}, baloldal={$lft}, jobboldal={$rgt}, szint={$szint}");
            //$this->_DB->prepare("UNLOCK TABLES;")->query_execute();
        }
        catch (Exception_MYSQL $e) {
        }
    }  
    
    public function getTartalom($kapcs_id, $table_name){
    	 $query = "
            SELECT {$table_name}_bekuldo AS bekuldo,
            	   IF(LENGTH({$table_name}_targy)>25, CONCAT(SUBSTR({$table_name}_targy,1,25),'...'),{$table_name}_targy) AS targy_min,
            	   {$table_name}_tartalom AS tartalom,
            	   IF(LENGTH({$table_name}_tartalom)>50, CONCAT(SUBSTR({$table_name}_tartalom,1,50),'...'),{$table_name}_tartalom) AS tartalom_min,
            	   {$table_name}_bekuldve_date AS bekuldve_date
            FROM {$table_name} 
            WHERE {$table_name}_id=".mysql_real_escape_string($kapcs_id)." AND 
                  {$table_name}_nyelv=".Rimo::$_config->SITE_NYELV_ID." AND  
                  {$table_name}_aktiv=1 AND 
                  {$table_name}_torolt=0 
            LIMIT 1
        ";
        //print $query;
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getParentTartalom($parent_id){
    	 $query = "
            SELECT hozzaszolas_bekuldo AS bekuldo,
				   hozzaszolas_tartalom AS tartalom, 
				   hozzaszolas_bekuldve_date AS bekuldve_date 	
            FROM {$this->_tableName} 
            WHERE {$this->_tableName}_id=".mysql_real_escape_string($parent_id)." AND 
                  hozzaszolas_nyelv=".Rimo::$_config->SITE_NYELV_ID." AND  
                  {$this->_tableName}_aktiv=1 AND 
                  {$this->_tableName}_torolt=0 
            LIMIT 1
        ";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
}
?>