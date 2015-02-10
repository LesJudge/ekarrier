<?php
class Hir_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "hir";
    public $_bindArray = array("hir_cim" => "TxtCim", 
                               "hir_link" => "TxtLink", 
                               "hir_leiras" => "TxtLeiras",
                               "hir_meta_kulcsszo" => "TxtKulcsszo",
                               "hir_tartalom" => "TxtTartalom",
                               "hir_szerzo" => "TxtSzerzo",
                               "hir_megjelenes" => "DateMegjelenes",
                               "hir_lejarat" => "DateLejarat",
                               "jogcsoport_id" => "SelGroup",
                               "hir_aktiv" => "ChkAktiv",
    );

    public function __addForm(){
        parent::__addForm();
        $this->addItem("TxtCim")->_verify["string"] = true;
        $link = $this->addItem("TxtLink");
        $link->_verify["string"] = true;
        $link->_verify["unique"] = array("table" => "hir", "field" => "hir_link", "modify" => $this->modifyID, "DB" => $this->_DB);
        $this->addItem("TxtLeiras")->_verify["string"] = true;
        $this->addItem("TxtKulcsszo")->_verify["required"] = true;
        $this->addItem("TxtTartalom")->_verify["string"] = true;
        $this->addItem("DateMegjelenes")->_verify["datetime"] = true;       
        $this->addItem("DateLejarat")->_verify["datetime"] = true;
        $this->addItem("DateLejarat")->_verify["datetimegreaterthan"] = $this->_params["DateMegjelenes"];
        $this->addItem("TxtSzerzo");
        $file = $this->addItem("File");
        $file->_verify["maxsize"] = 4194300;
        $file->_action_type = &$_FILES;
        $file->_verify["picture"] = true;
        
        $this->addItem("SelGroup")->_select_value = $this->getSelectValues("jogcsoport", "jogcsoport_nev", "AND site_tipus_id!=1","",false, array(0=>"--Mindenki--")); 
        $this->addItem("SelKapcsolodo")->_select_value = $this->getSelectValues("hir", "hir_cim");
        $kategoria = $this->addItem("SelKategoria");
        $kategoria->_select_value = $this->getKategoriaSelectValues();
        $kategoria->_verify["multiSelect"] = true;
    }
    
    public function deleteMegtekintes(){
        $query = "
            UPDATE {$this->_tableName} SET hir_megtekintve=0 
            WHERE hir_id='{$this->modifyID}' AND 
                  nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
    }
    
    public function deleteKep($file_name){
        $query = "
            UPDATE {$this->_tableName} SET hir_kep_nev='' 
            WHERE hir_id='{$this->modifyID}' AND 
                  nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
        @unlink("modul/".Rimo::$_config->APP_PATH."/upload/" . $file_name);
    }
    
    public function removeAccentsFromLink(){
        $this->_params["TxtLink"]->_value = Create::remove_accents($this->_params["TxtLink"]->_value);
    }
    
    public function removeDelimitterFromKulcsszo(){
        while(strpos($this->_params["TxtKulcsszo"]->_value,",,")!==false){
            $this->_params["TxtKulcsszo"]->_value = str_replace(",,", ",", $this->_params["TxtKulcsszo"]->_value);
        }
    }
    
    public function __newData(){
        parent::__newData();
        $this->_params["DateMegjelenes"]->_value = date("Y-m-d H:i");
        $this->_params["SelKapcsolodo"]->_select_value = $this->getSelectValues("hir", "hir_cim");
        $this->_params["SelKategoria"]->_value = 0;
    }
    
    public function __editData(){
        $query = "
            SELECT hir_megtekintve,
                   hir_javitas_szama, 
                   DATE_FORMAT(hir_create_date,'%Y-%m-%d %H:%i') AS hir_create_date, 
                   DATE_FORMAT(hir_modositas_datum,'%Y-%m-%d %H:%i') AS hir_modositas_datum, 
                   u1.user_fnev AS hir_letrehozo, 
                   u2.user_fnev AS hir_modosito,
                   hir_kep_nev
            FROM {$this->_tableName}
            LEFT JOIN user AS u1
                ON hir_letrehozo=u1.user_id
            LEFT JOIN user AS u2
                ON hir_modosito=u2.user_id
            WHERE hir_id='{$this->modifyID}' AND 
                  hir.nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    
    public function __formValues(){
        parent::__formValues();
        $this->_params["DateMegjelenes"]->_value = substr($this->_params["DateMegjelenes"]->_value,0,16);
        if(strpos($this->_params["DateLejarat"]->_value,"0000")!==false){
            $this->_params["DateLejarat"]->_value = "";
        }
        else{
            $this->_params["DateLejarat"]->_value = substr($this->_params["DateLejarat"]->_value,0,16);
        }
        $this->_params["SelKapcsolodo"]->_value = $this->getSelectAktivValues("hir_kapcsolodo");
        $this->_params["SelKategoria"]->_value = $this->getSelectAktivValues("hir_attr_kategoria");  
    }
    
    public function __update(){
        $this->saveSelect("hir_kapcsolodo", $this->_params["SelKapcsolodo"]->_value, $this->modifyID);
        $this->saveSelect("hir_attr_kategoria", $this->_params["SelKategoria"]->_value, $this->modifyID);
        
        if(strlen($this->_params["DateLejarat"]->_value)<2){
            $this->_params["DateLejarat"]->_value = "0000-00-00 00:00";
        }        
        parent::__update(",hir_modositas_datum=now(), hir_javitas_szama=hir_javitas_szama+1, hir_modosito=". UserLoginOut_Controller::$_id.", 
                          hir_kep_nev=".Create::upload_file($this->_params["File"]->_value, "hir_kep_nev"));
        if($this->_params["DateLejarat"]->_value=="0000-00-00 00:00"){
            $this->_params["DateLejarat"]->_value = "";
        }    
    }
    
    public function __insert(){
        if(strlen($this->_params["DateLejarat"]->_value)<2){
            $this->_params["DateLejarat"]->_value = "0000-00-00 00:00";
        }
        parent::__insert(",hir_create_date=now(), hir_letrehozo=".UserLoginOut_Controller::$_id.",
                          hir_kep_nev=".Create::upload_file($this->_params["File"]->_value, "hir_kep_nev"));
        $this->saveSelect("hir_kapcsolodo", $this->_params["SelKapcsolodo"]->_value, $this->insertID);
        $this->saveSelect("hir_attr_kategoria", $this->_params["SelKategoria"]->_value, $this->insertID);  
    }
    
    public function hirAllapot(){
        if($this->_params["ChkAktiv"]->_value!=1){
            return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A hir nem publikus!'></span>";
        }
        if($this->_params["DateMegjelenes"]->_value<date("Y-m-d H:i")){
            if(strpos($this->_params["DateLejarat"]->_value,"0000")!==false OR empty($this->_params["DateLejarat"]->_value) OR $this->_params["DateLejarat"]->_value>date("Y-m-d H:i")){
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
            }
            elseif($this->_params["DateLejarat"]->_value<date("Y-m-d H:i")){
                return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> Ellenőrizze a lejárati dátumot!'></span>";
            }
        }
        return "<span class='ui-icon ui-icon-info tip' title='<strong>Nem jelenik meg.</strong> Ellenőrizze a megjelenési dátumot!'></span>";
    }
    
    public function getKategoriaSelectValues() {
        try {
            $query = "
                     SELECT hir_kategoria_id AS id,   
                            kategoria_cim AS name,    
                            szint AS depth,
                            baloldal as bal,
                            jobboldal AS jobb
                     FROM  hir_kategoria    
                     WHERE nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID."   
                     GROUP BY hir_kategoria_id   
                     ORDER BY baloldal
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while ($adat = $obj->query_fetch_array()) {
                $added = "";
                for ($i = 0; $i < $adat["depth"]; $i++) {
                    $added .= "--";
                }
                if($adat["depth"]==0){
                    $list[$adat["id"]] = "<".$adat["name"].">";    
                }
                else{
                    $list[$adat["id"]] = $added.$adat["name"];
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