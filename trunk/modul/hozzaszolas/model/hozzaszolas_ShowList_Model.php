<?php
include_once "page/all/model/page.list_model.php";
class hozzaszolas_ShowList_Model extends Page_List_Model {
    public $_fields = "hozzaszolas_bekuldo, DATE_FORMAT(hozzaszolas_bekuldve_date,'%Y-%m-%d %H:%i') AS bekuldve,
                       hozzaszolas_tartalom, baloldal, jobboldal, szint
    ";
    
	public function __construct(){
        parent::__construct();
        $this->sortBY = "baloldal ASC";
    }
    
    public function __loadListCount(){
    	$this->_fields .= " ,{$this->_tableName}_id AS ID";
    	$this->listWhere=array(1=>$this->_tableName."_aktiv=1",2=>"kapcsolodo_id=".mysql_real_escape_string($_REQUEST["kapcs_id"]));
    	return parent::__loadListCount();
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
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
}
?>