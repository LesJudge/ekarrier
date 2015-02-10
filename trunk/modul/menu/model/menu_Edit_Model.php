<?php
include_once "modul/kategoria/model/kategoria_Master_Edit_Model.php";
class Menu_Edit_Model extends Kategoria_Master_Edit_Model {     
    public function __addForm() {
        $this->addItem("ChkAktiv")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        $this->addItem("TxtCim")->_verify["string"] = true;
        $link = $this->addItem("TxtLink")->_verify["string"] = true;       
        $parent = $this->addItem("SelParent");
        $parent->_select_value = $this->getParentSelectValues(true,"","menu_nev");
        $this->addItem("SelGroup")->_select_value = $this->getSelectValues("jogcsoport", "jogcsoport_nev", "AND site_tipus_id!=1","",false,array(0=>"--Mindenki--"));
        $this->addItem("SelDinamikusElem")->_select_value = $this->getMenuDinamikusSelectValues();
        $this->addItem("KategoriaLeft");
        $this->addItem("KategoriaRight");
        $this->addItem("KategoriaLevel");
        $this->_bindArray = array(
                                "menu_nev" => "TxtCim", 
                                "menu_link" => "TxtLink",
                                "menu_aktiv" => "ChkAktiv",  
                                "baloldal" => "KategoriaLeft", 
                                "jobboldal" => "KategoriaRight",
                                "szint" => "KategoriaLevel",
                                "jogcsoport_id" => "SelGroup",
                                "kapcsolodo_id" => "SelDinamikusElem"
        );
    }
    
    public function removeAccentsFromLink(){
    }
    
     public function __newData() {
        parent::__newData();
        $this->_params["SelParent"]->_select_value = $this->getParentSelectValues(true, "", "menu_nev");
    }
    
    public function __update(){
        parent::__update();
    }
    
    public function __insert(){
        if($this->modifyID){
            parent::__insert();
        }
        else
        {
            if($this->_params["SelParent"]->_value){
                $this->insertChildNode($this->_params["SelParent"]->_value);
            }
            else{
                $this->insertRootNode();
            }
        }  
        $this->_params["SelDinamikusElem"]->_value[0] = $this->_params["SelDinamikusElem"]->_value;
    }
    
    public function generateLinkAndName(&$dinamikus_elem){
        $dinamikus_elem->_value = $dinamikus_elem->_value[0];
        if(!$dinamikus_elem->_value)
            return "";
        $this->_params["TxtLink"]->_value = false;
        $array = explode("__",$dinamikus_elem->_value);
        $type = $array[0];
        $id = str_replace($type."__","",$dinamikus_elem->_value);
        try {
            switch ($type) {
               case "fix":
                    $this->_params["TxtLink"]->_value = Rimo::$_config->MENU_DinamikusLink[$id]; 
                    break;
               case "tart":
                        $query = "
                            SELECT tartalom_link AS link,
                                   tartalom_cim AS cim 
                            FROM tartalom 
                            WHERE tartalom_id={$id} AND 
                                  nyelv_id={$this->nyelvID} 
                        ";
                        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
                        $this->_params["TxtCim"]->_value = $data["cim"];
                        $this->_params["TxtLink"]->_value = $data["link"];
                    break;
               case "hk":
                        $query = "
                            SELECT kategoria_full_link AS link,
                                   kategoria_cim AS cim 
                            FROM hir_kategoria 
                            WHERE hir_kategoria_id={$id} AND 
                                  nyelv_id={$this->nyelvID} 
                        ";
                        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
                        $this->_params["TxtCim"]->_value = $data["cim"];
                        $this->_params["TxtLink"]->_value =  $data["link"]."/";
                    break;
               case "tk":
                        $query = "
                            SELECT kategoria_full_link AS link,
                                   kategoria_cim AS cim 
                            FROM termek_kategoria 
                            WHERE termek_kategoria_id={$id} AND 
                                  nyelv_id={$this->nyelvID} 
                        ";
                        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
                        $this->_params["TxtCim"]->_value = $data["cim"];
                        $this->_params["TxtLink"]->_value =  $data["link"]."/";
                    break;
               default: 
                    break;
            }
            if(!$this->_params["TxtLink"]->_value)
                throw new Exception_Form_Error("A kiválasztott dinamikus elem linkjét nem sikerült beállítani");
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("A kiválasztott dinamikus elem linkjét nem sikerült beállítani");
        }
    }
    
    public function getMenuDinamikusSelectValues(){
        $selectValues = Rimo::$_config->MENU_DinamikusSelect;
        $tartalmak = $this->getSelectValues("tartalom","tartalom_cim","AND tartalom_default=0","ORDER BY tartalom_cim");
        foreach($tartalmak as $key=>$val){
            $selectValues["Tartalmak"]["tart__{$key}"] = $val;
        }
        
        $hir_kategoriak = $this->getKategoria("hir_kategoria","kategoria_cim","hk__");
        if($hir_kategoriak){
            $selectValues["Hír kategóriák"] = $hir_kategoriak; 
        }
        $termek_kategoriak = $this->getKategoria("termek_kategoria","kategoria_cim","tk__");
        if($termek_kategoriak){
            $selectValues["Termék kategóriák"] = $termek_kategoriak; 
        }
        return $selectValues;
    }
    
    public function getKategoria($table, $name_field, $added_id, $where="" ) {
        try {
            $query = "
                     SELECT {$table}_id AS id,   
                            {$name_field} AS name,    
                            szint AS depth,
                            baloldal as bal,
                            jobboldal AS jobb
                     FROM {$table}         
                     WHERE nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID."   
                           {$where}    
                     GROUP BY {$table}_id   
                     ORDER BY baloldal
                ";
            $obj = $this->_DB->prepare($query)->query_select();
            while ($adat = $obj->query_fetch_array()) {
                $added = "";
                for ($i = 0; $i < $adat["depth"]+1; $i++) {
                    $added .= "--";
                }
                if($adat["depth"]==0){
                    $list[$added_id.$adat["id"]] = "<".$adat["name"].">";    
                }
                else{
                    $list[$added_id.$adat["id"]] = $added." ".$adat["name"];
                }
            }
            return $list;
        }
        catch (Exception_MYSQL_Null_Rows $e) {
            return false;
        }
        catch (Exception_MYSQL $e) {
            return array("0" => "HIBA");
        }
    }
}
?>