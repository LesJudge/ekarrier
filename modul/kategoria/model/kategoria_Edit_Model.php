<?php
include_once "modul/kategoria/model/kategoria_Master_Edit_Model.php";
class Kategoria_Edit_Model extends Kategoria_Master_Edit_Model {
     public function __addForm() {
        parent::__addForm();
        $this->addItem("TxtLeiras")->_verify["string"] = true;
        $this->addItem("TxtKulcsszo")->_verify["required"] = true;
        //$this->addItem("ChkMunkaAdo");
        $file = $this->addItem("File");
        $file->_verify["maxsize"] = 4194300;
        $file->_action_type = &$_FILES;
        $file->_verify["picture"] = true;
        
        if($this->modifyID){
            $where = " AND {$this->_tableName}_id<>{$this->modifyID} ";
        }
        $this->addItem("SelKapcsolodo")->_select_value = $this->getParentSelectValues(false, $where);

        $this->_bindArray["kategoria_cim"] = "TxtCim";
        $this->_bindArray["kategoria_link"] = "TxtLink";
        $this->_bindArray["kategoria_leiras"] = "TxtLeiras";
        $this->_bindArray["kategoria_meta_kulcsszo"] = "TxtKulcsszo";
        //$this->_bindArray["kategoria_ma"] = "ChkMunkaAdo";
    }
    
    public function deleteKep($file_name) {
        $query = "
            UPDATE {$this->_tableName} SET kategoria_kep_nev='' 
            WHERE {$this->_tableName}_id='{$this->modifyID}' AND 
                  nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
        @unlink("modul/" . Rimo::$_config->APP_PATH . "/upload/" . $file_name);
    }
    
      public function deleteMegtekintes(){
        $query = "
            UPDATE {$this->_tableName} SET kategoria_megtekintve=0 
            WHERE {$this->_tableName}_id='{$this->modifyID}' AND 
                  nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
    }
    
    public function removeDelimitterFromKulcsszo() {
        while (strpos($this->_params["TxtKulcsszo"]->_value, ",,") !== false) {
            $this->_params["TxtKulcsszo"]->_value = str_replace(",,", ",", $this->_params["TxtKulcsszo"]->_value);
        }
    }
    
    public function __editData() {
        $query = "
            SELECT kategoria_javitas_szama, 
                   DATE_FORMAT(kategoria_create_date,'%Y-%m-%d %H:%i') AS kategoria_create_date, 
                   DATE_FORMAT(kategoria_modositas_datum,'%Y-%m-%d %H:%i') AS kategoria_modositas_datum, 
                   u1.user_fnev AS kategoria_letrehozo, 
                   u2.user_fnev AS kategoria_modosito,
                   kategoria_kep_nev
            FROM {$this->_tableName}
            LEFT JOIN user AS u1
                ON kategoria_letrehozo=u1.user_id
            LEFT JOIN user AS u2
                ON kategoria_modosito=u2.user_id
            WHERE {$this->_tableName}_id='{$this->modifyID}' AND 
                  {$this->_tableName}.nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    
    public function __formValues() {
        parent::__formValues();
        if(is_object($this->_params["SelKapcsolodo"]))
            $this->_params["SelKapcsolodo"]->_value = $this->getSelectAktivValues("{$this->_tableName}_kapcsolodo");
    }
    
    public function __newData() {
        parent::__newData();
        if($this->modifyID){
            $where = " AND {$this->_tableName}_id<>{$this->modifyID} ";
        }
        $this->_params["SelKapcsolodo"]->_select_value = $this->getParentSelectValues(false, $where); 
    }
    
    public function __update(){   
        $this->saveSelect("{$this->_tableName}_kapcsolodo", $this->_params["SelKapcsolodo"]->_value, $this->modifyID);
        $kategoria_old_link = $this->getKategoriaOldLink($this->modifyID);
        parent::__update(", kategoria_modositas_datum=now(), kategoria_javitas_szama=kategoria_javitas_szama+1, kategoria_modosito=". UserLoginOut_Controller::$_id.", 
                          kategoria_kep_nev=".Create::upload_file($this->_params["File"]->_value, "kategoria_kep_nev"));
        $this->updateTreeLinkAndMenu($this->modifyID, $kategoria_old_link, $this->_params["TxtLink"]->_value, $this->_params["TxtCim"]->_value, $this->_params["ChkAktiv"]->_value);
    }
    
    public function __insert(){
        if($this->modifyID){
            $parent_link = $this->getNyelvFullLink($this->modifyID);
            if($parent_link){
                parent::__insert(",kategoria_create_date=now(), kategoria_letrehozo=".UserLoginOut_Controller::$_id.",
                              kategoria_kep_nev=".Create::upload_file($this->_params["File"]->_value, "kategoria_kep_nev"));
                $this->insertFullLink($this->modifyID, $this->_params["TxtLink"]->_value,"", $parent_link);
            }
            else{
               parent::__insert(",kategoria_full_link='".$this->_params["TxtLink"]->_value."',kategoria_create_date=now(), kategoria_letrehozo=".UserLoginOut_Controller::$_id.",
                              kategoria_kep_nev=".Create::upload_file($this->_params["File"]->_value, "kategoria_kep_nev"));
            }
            $this->insertMenu($this->modifyID, $this->_params["TxtCim"]->_value, $this->_params["TxtLink"]->_value, $this->_params["ChkAktiv"]->_value); 
        }
        else{
            if($this->_params["SelParent"]->_value){
                $this->insertChildNode($this->_params["SelParent"]->_value, ",kategoria_create_date=now(), kategoria_letrehozo=".UserLoginOut_Controller::$_id.",
                              kategoria_kep_nev=".Create::upload_file($this->_params["File"]->_value, "kategoria_kep_nev"));
                $this->insertFullLink($this->insertID, $this->_params["TxtLink"]->_value, $this->_params["SelParent"]->_value);
            }
            else{
                $this->insertRootNode(",kategoria_full_link='".$this->_params["TxtLink"]->_value."',kategoria_create_date=now(),kategoria_letrehozo=".UserLoginOut_Controller::$_id.",
                              kategoria_kep_nev=".Create::upload_file($this->_params["File"]->_value, "kategoria_kep_nev"));
            }
        }
        $this->saveSelect("{$this->_tableName}_kapcsolodo", $this->_params["SelKapcsolodo"]->_value, $this->insertID);  
    }
    
    private function getNyelvFullLink($id){
        try{
                $query = "
                    SELECT parent.kategoria_full_link AS kategoria_full_link
                    FROM {$this->_tableName} AS node 
                    INNER JOIN  {$this->_tableName} AS parent
                    WHERE parent.baloldal < node.baloldal AND 
                          parent.jobboldal > node.jobboldal AND 
                          parent.szint=node.szint-1 AND   
                          node.{$this->_tableName}_id=$id AND 
                          parent.nyelv_id={$this->nyelvID}  
                ";
                return $this->_DB->prepare($query)->query_select()->query_fetch_array("kategoria_full_link");
            } catch(Exception_MYSQL_Null_Rows $e){
                if($this->_params["KategoriaLevel"]->_value!=0)
                    throw new Exception_Form_Error("Hiba a nyelvesítés közben. Kérjük a nyelvesítést a lista oldal sorrendje szerint, fentről lefelé haladva végezze");
                return false;
            }           
    }
    
    private function insertFullLink($id, $link, $parent_id="", $parent_link=""){
        if($parent_id){
            $query = "
                SELECT kategoria_full_link 
                FROM {$this->_tableName} 
                WHERE {$this->_tableName}_id=$parent_id AND 
                      nyelv_id={$this->nyelvID}    
            ";
            $full_link = $this->_DB->prepare($query)->query_select()->query_fetch_array("kategoria_full_link")."/{$id}-{$link}";
        }
        elseif($parent_link){
            $full_link = "{$parent_link}/{$id}-{$link}";
        }
        else {
            $full_link = "{$id}-{$link}";
        }
        $query = "
            UPDATE {$this->_tableName} 
            SET kategoria_full_link='{$full_link}' 
            WHERE {$this->_tableName}_id={$id} AND 
                  nyelv_id={$this->nyelvID}    
        ";
        $this->_DB->prepare($query)->query_update();
    }
    
    private function updateTreeLinkAndMenu($id, $oldlink, $uj_link, $nev, $aktiv){
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
                $bal = $this->_params["KategoriaLeft"]->_value-1;
                $jobb = $this->_params["KategoriaRight"]->_value+1;
                $query = "
                    UPDATE {$this->_tableName} 
                    SET kategoria_full_link=REPLACE(kategoria_full_link,'{$this->modifyID}-{$oldlink}','$this->modifyID-{$uj_link}')
                    WHERE baloldal BETWEEN {$bal} AND {$jobb} AND 
                          nyelv_id={$this->nyelvID} 
                ";
                $this->_DB->prepare($query)->query_update();
                
                $query = "
                    SELECT {$this->_tableName}_id
                    FROM {$this->_tableName}  
                    WHERE baloldal BETWEEN {$bal} AND {$jobb} AND 
                          nyelv_id={$this->nyelvID}
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
                        menu_link = REPLACE(menu_link,'{$this->modifyID}-{$oldlink}','$this->modifyID-{$uj_link}')
                    WHERE {$menu_where} AND 
                          nyelv_id={$this->nyelvID}
                ";
                $this->_DB->prepare($query)->query_update();
            }
            catch(Exception_MYSQL_Null_Affected_Rows $e){
            }
            catch(Exception_MYSQL_Null_Rows $e){
            }
        }
        /*A menü nevének frissítése*/
        try{
            $query = "
                UPDATE menu 
                SET menu_nev='{$nev}', 
                    menu_aktiv={$aktiv}
                WHERE kapcsolodo_id='{$type}__{$this->modifyID}' AND  
                      nyelv_id={$this->nyelvID}
            ";
            $this->_DB->prepare($query)->query_update();
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
        }
    }
    
    private function getKategoriaOldLink($id){
        $query = "
            SELECT kategoria_link 
            FROM {$this->_tableName} 
            WHERE {$this->_tableName}_id={$id} AND 
                  nyelv_id={$this->nyelvID} 
        ";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array("kategoria_link");
    }
    
    private function insertMenu($id, $nev, $link, $statusz){
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
                SELECT szint, 
                       baloldal, 
                       jobboldal,
                       menu_id
                FROM menu 
                WHERE kapcsolodo_id='{$type}__{$id}'
                LIMIT 1
            ";
            $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
            $query = "
                INSERT INTO menu 
                SET menu_nev='{$nev}',
                    menu_link='{$link}',
                    menu_aktiv={$statusz},
                    kapcsolodo_id='{$type}__{$id}', 
                    nyelv_id={$this->nyelvID},
                    szint={$data["szint"]},
                    baloldal={$data["baloldal"]},
                    jobboldal={$data["jobboldal"]},
                    menu_id={$data["menu_id"]}
            ";
            $this->_DB->prepare($query)->query_insert();
        }catch(Exception_MYSQL_Null_Rows $e){
        }
    }
}
?>