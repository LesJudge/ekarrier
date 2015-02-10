<?php
class kategoria_Tree_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function getTree($table){
        try{
        	$query = "
	            SELECT baloldal, jobboldal 
	            FROM termek_kategoria 
	            WHERE termek_kategoria_id=1 AND 
	                  nyelv_id=".Rimo::$_config->SITE_NYELV_ID  
	        ;
	        $parent = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        	
	        $query = "
	            SELECT {$table}_kategoria_id AS id,   
	                   kategoria_cim AS menu_nev,
	                   szint,
	                   kategoria_full_link AS link  
	            FROM `{$table}_kategoria`  
	            WHERE baloldal > {$parent["baloldal"]} AND 
                  	  jobboldal < {$parent["jobboldal"]} AND 
					  nyelv_id=".Rimo::$_config->SITE_NYELV_ID."  AND 
	                  {$table}_kategoria_aktiv=1  
	            GROUP BY {$table}_kategoria_id 
	            ORDER BY baloldal ASC  
	        ";
	        $tree = $this->_DB->prepare($query)->query_select()->query_result_array();
	        $count = count($tree);
            $html = "<ul id='navigation' class='dropdown right'>";
            for ($i=0; $i<$count; $i++) { 
                $html .= "<li class='nav-".$tree[$i]["szint"]."'>" . "<a href='{$tree[$i]["link"]}/' class='frames'>".$tree[$i]["menu_nev"]."</a>";
			    if ($tree[$i]["szint"] < $tree[$i+1]["szint"]) {
                        $html .= "<ul class='subnav-".$tree[$i]["szint"]."'>";
    			} elseif ($tree[$i]["szint"] == $tree[$i+1]["szint"]) {
    				$html .= "</li>";
    			} else {
    				$diff = $tree[$i]["szint"] - $tree[$i+1]["szint"];
    				$html .= str_repeat("</li></ul>", $diff) . "</li>";
    			}
            }
            return $html;
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
}
?>