<?php
class Kategoria_Master_Edit_Model extends Admin_Edit_Model {
    public function __construct(){
        $this->_tableName = Rimo::$_config->KT_TABLE;
        parent::__construct();
    }
    public function __addForm() {
        parent::__addForm();
        $this->addItem("TxtCim")->_verify["string"] = true;
        $link = $this->addItem("TxtLink");
        $link->_verify["string"] = true;       
        $this->addItem("SelGroup")->_select_value = $this->getSelectValues("jogcsoport", "jogcsoport_nev", "AND site_tipus_id!=1","",false,array(0=>"--Mindenki--"));
        $parent = $this->addItem("SelParent");
        $parent->_select_value = $this->getParentSelectValues(true);
        $this->addItem("KategoriaLeft");
        $this->addItem("KategoriaRight");
        $this->addItem("KategoriaLevel");
        $this->_bindArray = array(
                                "jogcsoport_id" => "SelGroup", 
                                "{$this->_tableName}_aktiv" => "ChkAktiv", 
                                "baloldal" => "KategoriaLeft", 
                                "jobboldal" => "KategoriaRight",
                                "szint" => "KategoriaLevel"
        );
         $this->addItem("ChkMunkaAdo")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
    }
    
    public function removeAccentsFromLink() {
        $this->_params["TxtLink"]->_value = Create::remove_accents($this->_params["TxtLink"]->_value);
    }

    public function __newData() {
        parent::__newData();
        $this->_params["SelParent"]->_select_value = $this->getParentSelectValues(true);
    }

    /**
     * Főkategória létrehozása
     */
    public function insertRootNode($sets = "") {
        try {
            //$this->_DB->prepare("LOCK TABLES {$this->_tableName} WRITE")->query_execute();
            $query = "SELECT jobboldal FROM {$this->_tableName} ORDER BY jobboldal DESC LIMIT 1";
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
        $this->_params["KategoriaLeft"]->_value = $lft;
        $this->_params["KategoriaRight"]->_value = $rgt;
        $this->_params["KategoriaLevel"]->_value= 0;
        parent::__insert("{$sets}");
       // $this->_DB->prepare("UNLOCK TABLES")->query_execute();
    }

    /**
     * Új elem beszúrása esetén a fa újraépítése
     * @param integer $lft lft of parent node
     * @param integer $rgt	rgt of parent node
     */
    private function insertNode($lft, $rgt, $level) {
        try {
            $query = "UPDATE {$this->_tableName} SET jobboldal = jobboldal + 2 WHERE jobboldal >= {$rgt};";
            $this->_DB->prepare($query)->query_update();
            $query = "UPDATE {$this->_tableName} SET baloldal = baloldal + 2 WHERE baloldal > {$rgt};";
            $this->_DB->prepare($query)->query_update();
        }
        catch (Exception_MYSQL_Null_Affected_Rows $e) {
        }
        $this->_params["KategoriaLeft"]->_value = $rgt;
        $this->_params["KategoriaRight"]->_value = $rgt + 1;
        $this->_params["KategoriaLevel"]->_value = $level + 1;
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

    /**
     * Gyerek elem beszúrása
     */
    public function insertChildNode($parent, $sets = "") {
        try {
            //$this->_DB->prepare("LOCK TABLES {$this->_tableName} WRITE")->query_execute();
            $parent_node = $this->getNode($parent);
            $this->insertNode($parent_node["baloldal"], $parent_node["jobboldal"], $parent_node["szint"]);
            parent::__insert("{$sets}");
            //$this->_DB->prepare("UNLOCK TABLES;")->query_execute();
        }
        catch (Exception_MYSQL $e) {
        }
    }

    public function getParentSelectValues($add_root=false, $where="", $name_field="kategoria_cim") {
        try {
            $query = "
                 SELECT {$this->_tableName}_id AS id,   
                        {$name_field} AS name,    
                        szint AS depth,
                        baloldal as bal,
                        jobboldal AS jobb
                 FROM {$this->_tableName}         
                 WHERE nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID." 
                       {$where}    
                 GROUP BY {$this->_tableName}_id   
                 ORDER BY baloldal
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while ($adat = $obj->query_fetch_array()) {
                $added = "";
                for ($i = 0; $i < $adat["depth"]+1; $i++) {
                    $added .= "--";
                }
                if($adat["depth"]==0){
                    $list[$adat["id"]] = "<".$adat["name"].">";    
                }
                else{
                    $list[$adat["id"]] = $added." ".$adat["name"];
                }
                
            }
            return $list;
        }
        catch (Exception_MYSQL_Null_Rows $e) {
                return array();
        }
        catch (Exception_MYSQL $e) {
            return array("0" => "HIBA");
        }
    }
}
?>