<?php
class Banner_Edit_Model extends Admin_Edit_Model {    
    public $_tableName = "banner";
    public $_bindArray = array("banner_nev" => "TxtNev", 
                               "banner_link" => "TxtLink", 
                               "banner_kod" => "TxtKod",
                               "banner_pozicio" => "SelPozicio",
                               "banner_megjelenes" => "DateMegjelenes",
                               "banner_lejarat" => "DateLejarat",
                               "banner_sorrend" => "SelSorrend",
                               "banner_aktiv" => "ChkAktiv",
                               "banner_ma" => "ChkMunkaAdo"
    );

    public function __addForm(){
        parent::__addForm();
        $this->addItem("TxtNev")->_verify["string"] = true;
        $link = $this->addItem("TxtLink");
        $link->_verify["string"] = true;
        $this->addItem("TxtKod");
        
        $this->addItem("DateMegjelenes")->_verify["datetime"] = true;       
        $this->addItem("DateLejarat")->_verify["datetime"] = true;
        $this->addItem("DateLejarat")->_verify["datetimegreaterthan"] = $this->_params["DateMegjelenes"];
        $file = $this->addItem("File");        
        $file->_verify["maxsize"] = 4194300;
        $file->_action_type = &$_FILES;
        $file->_verify["picture"] = true;
         
        $SelPozicio = $this->addItem("SelPozicio");
        $SelPozicio->_verify["select"] = true;        
        $SelPozicio->_select_value = Rimo::$_config->POZICIO_AZ_OLDALON; 
        
		$selSorrend = $this->addItem("SelSorrend");
        $selSorrend->_verify["select"] = true;        
        $selSorrend->_select_value = Rimo::$_config->SORREND;
        
		$oldal = $this->addItem("SelOldal");
        $oldal->_select_value = $this->getOldal();
        $oldal->_verify["multiSelect"] = true;
        
        $this->addItem("ChkMunkaAdo")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
    }
    
	public function getOldal(){
        $selectValues = Rimo::$_config->OLDALSELECT_EDIT;
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
    
    private function getKategoria($table, $name_field, $added_id, $where="" ) {
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
    
    public function deleteKep($file_name){
        $query = "
            UPDATE {$this->_tableName} SET banner_kep_nev='' 
            WHERE banner_id='{$this->modifyID}' AND 
                  nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
        @unlink("modul/".Rimo::$_config->APP_PATH."/upload/" . $file_name);
    }    
    
    public function __newData(){
        parent::__newData();        
        $this->_params["DateMegjelenes"]->_value = date("Y-m-d H:i");
        $this->_params["ChkMunkaAdo"]->_value = 0;
    }
    
    public function __editData(){
        $query = "
            SELECT banner_kep_nev
            FROM {$this->_tableName}
            WHERE banner_id='{$this->modifyID}' AND 
                  nyelv_id='{$this->nyelvID}'
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
        $this->_params["SelOldal"]->_value = $this->getSelectAktivValues("banner_attr_oldal");
    }
    
    public function __update(){
        $this->saveSelect("banner_attr_oldal", $this->_params["SelOldal"]->_value, $this->modifyID);
        
        if(strlen($this->_params["DateLejarat"]->_value)<2){
            $this->_params["DateLejarat"]->_value = "0000-00-00 00:00";
        }    
                       
        parent::__update(", banner_kep_nev=".Create::upload_file($this->_params["File"]->_value, "banner_kep_nev"));                        
        if($this->_params["DateLejarat"]->_value=="0000-00-00 00:00"){
            $this->_params["DateLejarat"]->_value = "";
        }    
    }
    
    public function __insert(){  
        parent::__insert(",banner_kep_nev=".Create::upload_file($this->_params["File"]->_value, "banner_kep_nev"));
        $this->saveSelect("banner_attr_oldal", $this->_params["SelOldal"]->_value, $this->insertID);       
    }
    
     public function saveSelect($table, $input, $id){
        try{
            $this->_DB->prepare("DELETE FROM {$table} WHERE {$this->_tableName}_id={$id}")->query_execute();
        }catch(Exception_MYSQL $e){
        }
        if(is_array($input)){
            foreach($input as $val){
                $query = "
                INSERT INTO {$table} 
                SET 
                    {$this->_tableName}_id={$id},
                    banner_attr_oldal_id='".mysql_real_escape_string($val)."'";
                $this->_DB->prepare($query)->query_insert();
            }
        }
    }
    
    public function __verify_kotelezoseg(){        
        $file_hiba = false;
        if($this->_params["File"]->_value["error"]==4){
            $file_hiba = true;       
        }        
        else{
            $file_infos = getimagesize($this->_params["File"]->_value["tmp_name"]);
            $mime_type = $file_infos['mime'];
            if (!preg_match ("/jpg|jpeg|gif|png/i", $mime_type)) {
                $file_hiba = true; 
            }            
        }
        try{
			if($this->modifyID)
				$kep = $this->__editData();
	        if(empty($this->_params["TxtKod"]->_value) && $file_hiba && empty($kep["banner_kep_nev"])) {
	            $this->_params["File"]->_error = "A kód, vagy a kép megadása kötelező!";
	            return true;
	        }
    	}
    	catch(Exception_MYSQL $e){
    		if(empty($this->_params["TxtKod"]->_value) && $file_hiba){
	    		$this->_params["File"]->_error = "A kód, vagy a kép megadása kötelező!";
		        return true;
       		}
    	}
        return false;
    }    
}
?>