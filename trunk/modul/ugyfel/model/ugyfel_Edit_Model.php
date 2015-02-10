<?php
class Ugyfel_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "ugyfel";
    public $_bindArray = array("tartalom_cim" => "TxtCim", 
                               "tartalom_link" => "TxtLink", 
                               "tartalom_leiras" => "TxtLeiras",
                               "tartalom_meta_kulcsszo" => "TxtKulcsszo",
                               "tartalom_tartalom" => "TxtTartalom",
                               "tartalom_szerzo" => "TxtSzerzo",
                               "jogcsoport_id" => "SelGroup",
                               "tartalom_aktiv" => "ChkAktiv",
                               "tartalom_kezdolap" => "HidKezdolap", 
                               "tartalom_default" => "HidDefault"
	);

    public function __addForm(){
        parent::__addForm();
        $this->addItem("HidKezdolap");
        $this->addItem("HidDefault");
        $this->addItem("TxtCim")->_verify["string"] = true;
        $link = $this->addItem("TxtLink");
        $link->_verify["string"] = true;
        $link->_verify["unique"] = array("table" => "tartalom", "field" => "tartalom_link", "modify" => $this->modifyID, "DB" => $this->_DB);
        
        $this->addItem("TxtLeiras")->_verify["string"] = true;
        $this->addItem("TxtKulcsszo")->_verify["required"] = true;
        $this->addItem("TxtTartalom")->_verify["string"] = true;
        $this->addItem("TxtSzerzo");

        $file = $this->addItem("File");
        $file->_verify["maxsize"] = 4194300;
        $file->_action_type = &$_FILES;
        $file->_verify["picture"] = true;
        
        $this->addItem("SelGroup")->_select_value = $this->getSelectValues("jogcsoport", "jogcsoport_nev", "AND site_tipus_id!=1", "", false, array(0=>"--Mindenki--")); 
        $this->addItem("SelKapcsolodo")->_select_value = $this->getSelectValues("tartalom", "tartalom_cim");
    }
    
    public function deleteMegtekintes(){
        $query = "
            UPDATE {$this->_tableName} SET tartalom_megtekintve=0 
            WHERE tartalom_id='{$this->modifyID}' AND 
                  nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
    }
    
    public function deleteKep($file_name){
        $query = "
            UPDATE {$this->_tableName} SET tartalom_kep_nev='' 
            WHERE tartalom_id='{$this->modifyID}' AND 
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
        $this->_params["SelKapcsolodo"]->_select_value = $this->getSelectValues("tartalom", "tartalom_cim"); 
    }
    
    public function __editData(){
        $query = "
            SELECT tartalom_megtekintve,
                   tartalom_javitas_szama,  
                   DATE_FORMAT(tartalom_create_date,'%Y-%m-%d %H:%i') AS tartalom_create_date, 
                   DATE_FORMAT(tartalom_modositas_datum,'%Y-%m-%d %H:%i') AS tartalom_modositas_datum, 
                   u1.user_fnev AS tartalom_letrehozo, 
                   u2.user_fnev AS tartalom_modosito,
                   tartalom_kep_nev
            FROM {$this->_tableName}
            LEFT JOIN user AS u1
                ON tartalom_letrehozo=u1.user_id
            LEFT JOIN user AS u2
                ON tartalom_modosito=u2.user_id
            WHERE tartalom_id='{$this->modifyID}' AND 
                  {$this->_tableName}.nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    
    public function __formValues(){
        parent::__formValues();
        $this->_params["SelKapcsolodo"]->_value = $this->getSelectAktivValues("tartalom_kapcsolodo"); 
    }
    
    public function __update(){
        $this->saveSelect("tartalom_kapcsolodo", $this->_params["SelKapcsolodo"]->_value, $this->modifyID);    
        parent::__update(",tartalom_modositas_datum=now(), tartalom_javitas_szama=tartalom_javitas_szama+1, tartalom_modosito=". UserLoginOut_Controller::$_id.", 
                          tartalom_kep_nev=".Create::upload_file($this->_params["File"]->_value, "tartalom_kep_nev"));
        $this->updateMenu($this->modifyID, $this->_params["TxtCim"]->_value, $this->_params["TxtLink"]->_value, $this->_params["ChkAktiv"]->_value);
    }
    
    public function __insert(){
        parent::__insert(",tartalom_create_date=now(), tartalom_letrehozo=".UserLoginOut_Controller::$_id.",
                          tartalom_kep_nev=".Create::upload_file($this->_params["File"]->_value, "tartalom_kep_nev"));
        $this->saveSelect("tartalom_kapcsolodo", $this->_params['SelKapcsolodo']->_value, $this->insertID);
        if($this->modifyID)
            $this->insertMenu($this->modifyID, $this->_params["TxtCim"]->_value, $this->_params["TxtLink"]->_value, $this->_params["ChkAktiv"]->_value);      
    }
   
    private function updateMenu($id, $nev, $link, $statusz){
        try{
            $query = "
                UPDATE menu 
                SET menu_nev='".mysql_real_escape_string($nev)."',
                    menu_link='{$link}',
                    menu_aktiv={$statusz}
                WHERE kapcsolodo_id='tart__{$id}' AND 
                      nyelv_id={$this->nyelvID}
            ";    
            $this->_DB->prepare($query)->query_update();
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
        }
    }
    
    private function insertMenu($id, $nev, $link, $statusz){
        try{
            $query = "
                SELECT szint, 
                       baloldal, 
                       jobboldal,
                       menu_id
                FROM menu 
                WHERE kapcsolodo_id='tart__{$id}'
                LIMIT 1
            ";
            $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
            $query = "
                INSERT INTO menu 
                SET menu_nev='".mysql_real_escape_string($nev)."',
                    menu_link='{$link}',
                    menu_aktiv={$statusz},
                    kapcsolodo_id='tart__{$id}', 
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