<?php
class menu_Model extends Model {
    public function __construct() {
        $this->addDB("MYSQL_DB");
    }
    
    public function loadTree($parent_id, $jogok_where){
        $query = "
            SELECT baloldal, jobboldal 
            FROM menu 
            WHERE menu_id={$parent_id} AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID  
        ;
        $parent = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        
        $query = "
            SELECT menu_id AS id,   
                   menu_nev AS menu_nev,
                   szint,
                   menu_link  
            FROM `menu` 
            WHERE baloldal > {$parent["baloldal"]} AND 
                  jobboldal < {$parent["jobboldal"]} AND 
                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID."  AND 
                  menu_aktiv=1 AND  
              	  {$jogok_where}
            GROUP BY menu_id 
            ORDER BY baloldal ASC  
        ";
                  
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
}
?>