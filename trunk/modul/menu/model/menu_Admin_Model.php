<?php
class Menu_Admin_Model extends Model {
    public function __construct() {
        $this->addDB("MYSQL_DB");
    }
    
    public function loadTree($parent_id, $jogok_where){
        $query = "
            SELECT baloldal, jobboldal 
            FROM admin_menu 
            WHERE admin_menu_id={$parent_id} AND 
                  nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID  
        ;
        $parent = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        
        $query = "
            SELECT admin_menu_id AS id,   
                   menu_nev AS menu_nev,
                   szint,
                   menu_link  
            FROM `admin_menu` 
            WHERE baloldal > {$parent["baloldal"]} AND 
                  jobboldal < {$parent["jobboldal"]} AND 
                  nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID." AND  
                  admin_menu_aktiv=1 AND                   
              	  {$jogok_where}  
            GROUP BY admin_menu_id 
            ORDER BY baloldal ASC  
        ";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function loadChildTree($modul_link, $jogok_where, $szint){
        $query = "
            SELECT parent.baloldal AS baloldal, 
                   parent.jobboldal AS jobboldal, 
                   parent.szint AS szint
            FROM admin_menu AS child 
            INNER JOIN admin_menu AS parent
            WHERE parent.baloldal < child.jobboldal AND 
                  parent.jobboldal > child.jobboldal AND  
                  child.menu_link='{$modul_link}' AND 
                  parent.szint=child.szint-1 AND 
                  parent.szint={$szint} AND 
                  parent.nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID
        ;
                
        $parent = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        $szint = $szint+1;
        $query = "
            SELECT admin_menu_id AS id,   
                   menu_nev AS menu_nev,
                   szint,
                   menu_link  
            FROM `admin_menu` 
            WHERE baloldal > {$parent["baloldal"]} AND 
                  jobboldal < {$parent["jobboldal"]} AND 
                  szint={$szint} AND 
                  nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID." AND  
                  admin_menu_aktiv=1 AND                  
              	  {$jogok_where}  
            GROUP BY admin_menu_id 
            ORDER BY baloldal ASC  
        ";
        return $this->_DB->prepare($query)->query_select();
    }   
}
?>