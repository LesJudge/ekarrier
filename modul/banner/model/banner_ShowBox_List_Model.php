<?php
class banner_ShowBox_List_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    private function getBannerOldalID(){
    	if($_REQUEST["m"]==="galeria"){
    		return " banner_attr_oldal_id='fix__1' ";	
    	}
		if($_REQUEST["m"]==="user" AND $_REQUEST["al"]==="reg"){
    		return " banner_attr_oldal_id='fix__2' ";	
    	}
    	if($_REQUEST["m"]==="hir"){
    		if($_REQUEST["al"]=="showHir"){
    			return $this->getDinamikusParamReszletes("hir",$_REQUEST["link"],"hk__", " AND ( (NOW() BETWEEN hir_megjelenes AND hir_lejarat)  OR   (hir_megjelenes<NOW() AND hir_lejarat='0000-00-00 00:00:00') )");
    		}
    		else{
    			return $this->getDinamikusParam("hir",$_REQUEST["link"],"hk__");
    		}	
    	}
    	if($_REQUEST["m"]==="termek"){
    		if($_REQUEST["al"]=="showTermek"){
    			return $this->getDinamikusParamReszletes("termek",$_REQUEST["link"],"tk__");
    		}
    		else{
				return $this->getDinamikusParam("termek",$_REQUEST["link"],"tk__");
    		}	
    	}
    	
    	if($_REQUEST["m"]==="tartalom"){
			return $this->getDinamikusParamTartalom($_REQUEST["link"],"tart__");
    	}
        if($_REQUEST["m"]==="blog"){
			return " banner_attr_oldal_id='fix__6' ";
    	}
        if($_REQUEST["m"]==="tanfolyam"){
			return " banner_attr_oldal_id='fix__8' ";
    	}
        return "1=1";
    }
    
    private function getDinamikusParamTartalom($link, $added_name){
    	try{
            /* DEBUG
    		$query = "
    			SELECT tartalom_id
    			FROM tartalom 
				WHERE tartalom_aktiv=1 AND 
					  tartalom_torolt=0 AND  
					  tartalom_link='".mysql_real_escape_string($link)."' AND 
					  nyelv_id=".Rimo::$_config->SITE_NYELV_ID."  
					  {$where} 
		  	    LIMIT 1
			";
             END DEBUG
             */
                		$query = "
    			SELECT tartalom_id
    			FROM tartalom 
				WHERE tartalom_aktiv=1 AND 
					  tartalom_torolt=0 AND  
					  tartalom_link='".mysql_real_escape_string($link)."' AND 
					  nyelv_id=".Rimo::$_config->SITE_NYELV_ID."  
		  	    LIMIT 1
			";
			$obj = $this->_DB->prepare($query)->query_select();
			$row = $obj->query_fetch_array();
			return " banner_attr_oldal_id='".$added_name.$row["tartalom_id"]."' "; 
    	}
    	catch(Exception_MYSQL_Null_Rows $e){
    	   return " banner_attr_oldal_id='fix__4' ";
    	}
    }
    
    private function getDinamikusParam($table_name, $link, $added_name){
    	try{
    		$query = "
    			SELECT {$table_name}_kategoria_id
    			FROM {$table_name}_kategoria 
				WHERE {$table_name}_kategoria_aktiv=1 AND 
					  {$table_name}_kategoria_torolt=0 AND  
					  kategoria_full_link='".mysql_real_escape_string($link)."' AND 
					  {$table_name}_kategoria.nyelv_id=".Rimo::$_config->SITE_NYELV_ID."  
					  {$where} 
		  	    LIMIT 1
			";
			$obj = $this->_DB->prepare($query)->query_select();
			$row = $obj->query_fetch_array();
			return " banner_attr_oldal_id='".$added_name.$row[$table_name."_kategoria_id"]."' "; 
    	}
    	catch(Exception_MYSQL_Null_Rows $e){
    	}
    }
    
    private function getDinamikusParamReszletes($table_name, $link, $added_name, $where=""){
    	try{
    		$query = "
    			SELECT {$table_name}_attr_kategoria_id
    			FROM {$table_name}_attr_kategoria
    			INNER JOIN {$table_name} ON {$table_name}.{$table_name}_id={$table_name}_attr_kategoria.{$table_name}_id 
				INNER JOIN  {$table_name}_kategoria ON {$table_name}_kategoria_id={$table_name}_attr_kategoria_id AND 
					        {$table_name}_kategoria_aktiv=1 AND 
							{$table_name}_kategoria_torolt=0 
				WHERE {$table_name}_aktiv=1 AND 
					  {$table_name}_torolt=0 AND  
					  {$table_name}_link='".mysql_real_escape_string($link)."' AND 
					  {$table_name}_kategoria.nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND 
					  {$table_name}.nyelv_id=".Rimo::$_config->SITE_NYELV_ID."
					  {$where} 
		  	    GROUP BY {$table_name}_attr_kategoria_id
			";
			$return_where = "  (";
			$obj = $this->_DB->prepare($query)->query_select();
			while($row = $obj->query_fetch_array()){
				$return_where .= " banner_attr_oldal_id='".$added_name.$row[$table_name."_attr_kategoria_id"]."' OR "; 
			}
			$return_where .= " 1=2)";
			return $return_where;
    	}
    	catch(Exception_MYSQL_Null_Rows $e){
    	}
    }
    
    public function getBannerList($pozicio, $order_by, $limit=1, $ma=0){
    	$where = " AND (".$this->getBannerOldalID()." OR banner_attr_oldal_id='fix__3') AND banner_ma='".$ma."'";
        try{
            $query = "
                SELECT banner_link,
                       banner_kod,
                       banner_kep_nev,
                       banner_nev,
                       banner_ma
                FROM banner
				INNER JOIN banner_attr_oldal ON banner_attr_oldal.banner_id=banner.banner_id
				WHERE banner_pozicio={$pozicio} AND 
					  banner.nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND 
					  banner_aktiv=1 AND 
                      banner_torolt=0 AND 
                      ( 
                        (NOW() BETWEEN banner_megjelenes AND banner_lejarat)  OR   
                        (banner_megjelenes<NOW() AND banner_lejarat='0000-00-00 00:00:00') 
                      )  
                      {$where}
                GROUP BY banner.banner_id 
                ORDER BY {$order_by} 
                LIMIT {$limit}
            ";
              
           return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
}
?>