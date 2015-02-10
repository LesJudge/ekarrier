<?php
include_once "modul/kategoria/model/kategoria_Master_List_Model.php";
class Kategoria_List_Model extends Kategoria_Master_List_Model {
    public $tableHeader = array(
                            "kategoria_cim" => array("label" => "Cím", "width" => 80),
                            "node.kategoria_full_link" => array("label" => "Link", "width" => 80),
                            "jobb_testver" => array("label" => "Sorrend", "width" => 10),
                            "kategoria_megtekintve" => array("label" => "Megtekintve", "width" => 10),
                            "kategoria_aktiv" => array("label" => "Közzétéve", "width" => 8),
                            "kategoria_torolt" => array("label" => "Törlés", "width" => 8)
    );
    public function __construct(){
        parent::__construct();
        $this->_fields = "node.{$this->_tableName}_id AS ID,node.kategoria_cim AS elso, 
                       node.{$this->_tableName}_aktiv AS Aktiv, node.jobboldal-node.baloldal AS leaves,
                       node.kategoria_megtekintve, node.kapcsolodo_elemek, node.kategoria_full_link AS full_link, node.szint
        ";
    }
    
    public function MoveAll($ID,$newParentId){
        try{
            $query = "
                SELECT kategoria_full_link,
                       baloldal,
                       jobboldal 
               FROM {$this->_tableName} 
               WHERE {$this->_tableName}_id={$newParentId} AND 
                     nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID." 
            ";
            $data_parent = $this->_DB->prepare($query)->query_select()->query_fetch_array();
            
            $query = "
               SELECT kategoria_full_link,
              	      kategoria_link
               FROM {$this->_tableName} 
               WHERE {$this->_tableName}_id={$ID} AND 
                     nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID." 
            ";
            $data_node = $this->_DB->prepare($query)->query_select()->query_fetch_array();
            
            $uj_link = $data_parent["kategoria_full_link"]."/".$ID."-".$data_node["kategoria_link"];
            $old_link = $data_node["kategoria_full_link"];
            
            $this->updateTreeLinkAndMenu($old_link,$uj_link,$data_parent["baloldal"], $data_parent["jobboldal"]);
        }catch(Exception_MYSQL_Null_Rows $e){
            
        }
    }
    
    private function updateTreeLinkAndMenu($oldlink, $uj_link, $bal, $jobb){
        switch ($this->_tableName) {
            case "hir_kategoria":
                $type="hk";
                break;
            case "termek_kategoria":
                $type="tk";
                break;
            default: 
                break;
        }
        if($oldlink!==$uj_link){
            try{
                $query = "
                    UPDATE {$this->_tableName} 
                    SET kategoria_full_link=REPLACE(kategoria_full_link,'{$oldlink}','{$uj_link}')
                    WHERE baloldal BETWEEN {$bal} AND {$jobb} AND 
                          nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID."  
                ";
                $this->_DB->prepare($query)->query_update();
                
                $query = "
                    SELECT {$this->_tableName}_id
                    FROM {$this->_tableName}  
                    WHERE baloldal BETWEEN {$bal} AND {$jobb} AND 
                          nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID." 
                ";
                $obj = $this->_DB->prepare($query)->query_select();
                
                /*A menü linkjének frissítése*/
                $menu_where = " ( ";
                while($valtozott_id = $obj->query_fetch_array("{$this->_tableName}_id")){
                    $menu_where .= " kapcsolodo_id='{$type}__{$valtozott_id}' OR ";
                }
                $menu_where .= " 1=2)"; //:)
                $query = "
                    UPDATE menu 
                    SET 
                        menu_link = REPLACE(menu_link,'{$oldlink}','{$uj_link}')
                    WHERE {$menu_where} AND 
                          nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID." 
                ";
                $this->_DB->prepare($query)->query_update();
            }
            catch(Exception_MYSQL_Null_Affected_Rows $e){
            }
            catch(Exception_MYSQL_Null_Rows $e){
            }
        }
    }
    
    public function updateMenuStatusz($id, $val){
         switch ($this->_tableName) {
            case "hir_kategoria":
                $type="hk";
                break;
            case "termek_kategoria":
                $type="tk";
                break;
            default: 
                break;
        }
        try{
            $query = "
                UPDATE menu 
                SET menu_aktiv=$val
                WHERE kapcsolodo_id='{$type}__{$id}' AND 
                      nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID
            ;
            $this->_DB->prepare($query)->query_update();
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
        }
    }
}
?>