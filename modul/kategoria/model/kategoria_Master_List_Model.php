<?php
class Kategoria_Master_List_Model extends Admin_List_Model {
    public function __construct(){
        $this->_tableName = Rimo::$_config->KT_TABLE;
        parent::__construct();
    }
    
    public function __addForm(){
        parent::__addForm();  
        $this->addItem("NewParent")->_select_value = array();
    }
    
    public function __loadList(){
       $this->listWhere = str_replace("{$this->_tableName}_torolt=0 AND","",$this->listWhere);
       $this->listWhere = str_replace("{$this->_tableName}.nyelv_id=","node.nyelv_id=", $this->listWhere);
       $this->sortBY = "node.baloldal";
       if(!empty($this->sortBY)){
            $order = " ORDER BY {$this->sortBY}";
       }
       $query =  "
            SELECT {$this->_fields},
                   parent.{$this->_tableName}_id AS parent,
                   jobb.{$this->_tableName}_id AS jobb_testver,
                   bal.{$this->_tableName}_id AS bal_testver
            FROM `{$this->_tableName}` AS node 
            LEFT JOIN `{$this->_tableName}` AS parent ON 
                parent.baloldal < node.baloldal AND 
                parent.jobboldal > node.jobboldal AND 
                parent.szint = node.szint-1
            LEFT JOIN `{$this->_tableName}` AS jobb ON 
                jobb.baloldal=node.jobboldal+1
            LEFT JOIN `{$this->_tableName}` AS bal ON 
                bal.jobboldal=node.baloldal-1
            {$this->listWhere}
            GROUP BY node.{$this->_tableName}_id 
            {$order} 
        "; 
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
     /**
     * Visszaadja az adott kategória oldal értékeit.
     */
    public function getNode($id) {
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
    
    
     private function getNodeSize(&$node){
        return $node["jobboldal"] - $node["baloldal"] + 1;
    }
     
    /**
    * Delete element with number $id from the tree wihtout deleting it's children.
    *
    * @param integer $ID Number of element
    */
    function deleteKategoria($ID) {
        $node_info = $this->getNode($ID);
        $leftId = $node_info["baloldal"];
        $rightId = $node_info["jobboldal"];        
        
        $sql = 'DELETE FROM ' . $this->_tableName . ' WHERE ' . $this->_tableName . '_id = ' . (int)$ID;
        $this->_DB->prepare($sql)->query_execute();
        
        $sql = '
            UPDATE ' . $this->_tableName . ' 
            SET 
                szint = 
                    CASE 
                        WHEN baloldal BETWEEN ' . $leftId . ' AND ' . $rightId . ' 
                            THEN szint - 1 
                        ELSE szint END, 
                jobboldal = 
                    CASE 
                        WHEN jobboldal BETWEEN ' . $leftId . ' AND ' . $rightId . ' 
                            THEN jobboldal - 1  
                        WHEN jobboldal > ' . $rightId . ' 
                            THEN jobboldal - 2 
                        ELSE jobboldal END, 
                baloldal = 
                    CASE 
                        WHEN baloldal BETWEEN ' . $leftId . ' AND ' . $rightId . ' 
                            THEN baloldal - 1 
                        WHEN baloldal > ' . $rightId . ' 
                            THEN baloldal - 2 
                        ELSE baloldal END
            WHERE jobboldal > ' . $leftId;
        try{
            $this->_DB->prepare($sql)->query_update();
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
        }
    }
    
    public function updateTreeItem($ID, $left, $right, $szint){
    	try{
			$query = "
	    		UPDATE {$this->_tableName} 
	   			SET baloldal={$left},
	   				jobboldal={$right},
   					szint={$szint}
				WHERE {$this->_tableName}_id={$ID}
			";
			$this->_DB->prepare($query)->query_update();
		}catch(Exception_MYSQL_Null_Affected_Rows $e){
		}
    }
}
?>