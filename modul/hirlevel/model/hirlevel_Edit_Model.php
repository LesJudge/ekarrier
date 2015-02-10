<?php
class Hirlevel_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "hirlevel";
    public $_bindArray = array("hirlevel_targy" => "TxtTargy", 
                               "hirlevel_felado_nev" => "TxtFeladoNev", 
                               "hirlevel_felado_email" => "TxtFeladoEmail",
                               "hirlevel_tartalom" => "TxtTartalom",
                               "hirlevel_proba" => "ChkProba",
                               "hirlevel_kuldes_datum" => "DateKikuldes"
    );

    public function __addForm(){
        $this->addItem("TxtTargy")->_verify["string"] = true;
        $this->addItem("TxtFeladoNev")->_verify["string"] = true;
        $felado_email =  $this->addItem("TxtFeladoEmail");
        $felado_email->_verify["string"] = true;
        $felado_email->_verify["email"] = true;
        $this->addItem("TxtTartalom")->_verify["string"] = true;
        $this->addItem("DateKikuldes")->_verify["datetime"] = true;
        $this->addItem("ChkProba")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];;
        
        $csoport = $this->addItem("SelCsoport");
        $csoport->_select_value = $this->getCsoportSelectValue();
    }
    
    private function getCsoportSelectValue(){
        try{
            $query = "
                SELECT hirlevel_csoport_id, hirlevel_csoport_nev, COUNT(hirlevel_user.hirlevel_user_id) AS szum
                FROM hirlevel_csoport
                INNER JOIN hirlevel_user_attr_csoport ON hirlevel_user_attr_csoport_id=hirlevel_csoport_id
                INNER JOIN hirlevel_user 
                    ON hirlevel_user.hirlevel_user_id=hirlevel_user_attr_csoport.hirlevel_user_id AND 
                       hirlevel_user_leiratkozva=0 AND hirlevel_user_torolt=0	
                WHERE hirlevel_csoport_torolt=0 
                GROUP BY hirlevel_csoport_id
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while($adat = $obj->query_fetch_array()){
                $list[$adat["hirlevel_csoport_id"]] = $adat["hirlevel_csoport_nev"]." (".$adat["szum"].")";
            }
            return $list;
        }
        catch(Exception_MYSQL_Null_Rows $e){
            
        }
    }
      
    public function __newData(){
        parent::__newData();
        if(!$this->_params["TxtFeladoNev"]->_value){ 
            $this->_params["ChkProba"]->_value=1;
            $this->_params["DateKikuldes"]->_value = date("Y-m-d H:i");
            $this->_params["TxtFeladoNev"]->_value = Rimo::$_config->HK_FELADO_NEV;
            $this->_params["TxtFeladoEmail"]->_value = Rimo::$_config->HK_FELADO_EMAIL;
        }
    }
    
    public function loadSablon(){
        try{
            $query = "
                SELECT sablon_id, 
                       sablon_nev
                FROM sablon 
                WHERE sablon_tipus='hirlevel' AND 
                      sablon_torolt=0
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            $sablon = "[ ";
            $i=0;
            while($row = $obj->query_fetch_array()){
                if($i!=0)
                    $sablon .= ",";    
                $sablon.= "{ title:'". $row["sablon_nev"]."', 
                                     src:'".Rimo::$_config->DOMAIN_ADMIN."ajax.php?m=sablon&al=show&id=".$row["sablon_id"]."', 
                                     description:'".$row["sablon_nev"]."'
                                   }";
                $i++; 
            }
            $sablon .= " ]";
            return $sablon;
        }
        catch(Exception_MYSQL_Null_Rows $e){
        }
    }
    
    public function __editData(){
        $query = "
            SELECT hirlevel_javitas_szama,  
                   DATE_FORMAT(hirlevel_create_date,'%Y-%m-%d %H:%i') AS hirlevel_create_date, 
                   DATE_FORMAT(hirlevel_modositas_datum,'%Y-%m-%d %H:%i') AS hirlevel_modositas_datum, 
                   u1.user_fnev AS hirlevel_letrehozo, 
                   u2.user_fnev AS hirlevel_modosito,
                   hirlevel_cimzett_szum,
                   hirlevel_kikuldve,
                   hirlevel_megnyitva,
                   hirlevel_lezarva
            FROM {$this->_tableName}
            LEFT JOIN user AS u1
                ON hirlevel_letrehozo=u1.user_id
            LEFT JOIN user AS u2
                ON hirlevel_modosito=u2.user_id
            WHERE hirlevel_id='{$this->modifyID}' 
            LIMIT 1
        ";        
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    
    public function __formValues(){
        parent::__formValues();
        $this->_params["DateKikuldes"]->_value = substr($this->_params["DateKikuldes"]->_value,0,16);
        $this->_params["SelCsoport"]->_value =  $this->getSelectAktivValues("hirlevel_attr_csoport"); 
    }
    
    public function __update(){
        $this->saveSelect("hirlevel_attr_csoport", $this->_params["SelCsoport"]->_value, $this->modifyID);    
        parent::__update(",hirlevel_megnyitva=0,hirlevel_modositas_datum=now(), hirlevel_javitas_szama=hirlevel_javitas_szama+1, hirlevel_modosito=". UserLoginOut_Controller::$_id);
    }
    
    public function __insert(){
        parent::__insert(",hirlevel_megnyitva=0,hirlevel_create_date=now(), hirlevel_letrehozo=".UserLoginOut_Controller::$_id);
        $this->saveSelect("hirlevel_attr_csoport", $this->_params["SelCsoport"]->_value, $this->insertID);      
    }
    
    public function insertKikuldendo(){
        if($this->modifyID)
            $hirlevel_id =$this->modifyID;
        else
            $hirlevel_id =$this->insertID;
        $tartalom = new Smarty();
        $tartalom->assign("domain",Rimo::$_config->DOMAIN);
        $users = $this->getUsers();
        $cimzettek_szama=0;
        while($user = $users->query_fetch_array()){
            if($this->_params["ChkProba"]->_value==0)
                $tartalom->assign("leiratkozas_link",Rimo::$_config->DOMAIN."hirlevel/leiratkozas/".md5($user["id"]));
            $tartalom->assign("cimlista_szemely_nev", $user["nev"]);
            $tartalom->assign("cimlista_szemely_email",$user["email"]);
            $full_tartalom = $tartalom->fetch('string:'.$this->_params["TxtTartalom"]->_value);
            $full_tartalom = "<img src='".Rimo::$_config->DOMAIN."hirlevel/megnyitas/{$hirlevel_id}/".md5($user["id"])."'>{$full_tartalom}";
            $full_tartalom = str_replace("modul/file_browser/upload/",Rimo::$_config->DOMAIN."modul/file_browser/upload/",$full_tartalom);
            $query = "
                INSERT INTO hirlevel_kikuldendo
                SET 
                    hirlevel_id={$hirlevel_id},
                    hirlevel_targy='".mysql_real_escape_string($this->_params["TxtTargy"]->_value)."',
                    hirlevel_felado_nev='".mysql_real_escape_string($this->_params["TxtFeladoNev"]->_value)."',
                    hirlevel_felado_email='".mysql_real_escape_string($this->_params["TxtFeladoEmail"]->_value)."',
                    hirlevel_proba='".mysql_real_escape_string($this->_params["ChkProba"]->_value)."',
                    hirlevel_user_id={$user["id"]},
                    hirlevel_user_email='{$user["email"]}',
                    hirlevel_kikuldendo_tartalom='".mysql_real_escape_string($full_tartalom)."',
                    hirlevel_kikuldendo_create_date=now(),
                    hirlevel_kikuldendo_send_date='".mysql_real_escape_string($this->_params["DateKikuldes"]->_value)."'
            ";
            $this->_DB->prepare($query)->query_insert();
            $cimzettek_szama++;
        }            
        return $cimzettek_szama;
    }
    
    private function getUsers(){
        if($this->_params["ChkProba"]->_value==1){
            $query = "
                SELECT hirlevel_probauser_id AS id, 
                       hirlevel_probauser_nev AS nev, 
                       hirlevel_probauser_email AS email
                FROM hirlevel_probauser 	   
                WHERE hirlevel_probauser_torolt=0
            ";
        }else {
            $query = "
                SELECT hirlevel_user.hirlevel_user_id AS id, 
                       hirlevel_user_nev AS nev, 
                       hirlevel_user_email AS email
                FROM hirlevel_user 
                INNER JOIN hirlevel_user_attr_csoport ON 
                    hirlevel_user_attr_csoport.hirlevel_user_id=hirlevel_user.hirlevel_user_id
                WHERE hirlevel_user_leiratkozva=0 AND 
                      hirlevel_user_torolt=0 AND 
                      hirlevel_user_attr_csoport_id IN ( 
                            ".implode(",",$this->_params["SelCsoport"]->_value).")
                GROUP BY hirlevel_user.hirlevel_user_id
            ";
        }
        try{
            return $this->_DB->prepare($query)->query_select();
        }catch(Exception_MYSQL_Null_Rows $e){
            if($this->_params["ChkProba"]->_value==1)
                throw new Exception_Form_Error("HIBA A KÜLDÉSBEN! A próba címlista üres");
            throw new Exception_Form_Error("HIBA A KÜLDÉSBEN! A hírlevélhez választott címlistában nem szerepelnek személyek");
        }
    }
    
    public function updateHirlevel($cimzettek_szama=0){
       try{ 
           if($this->modifyID)
                $id=$this->modifyID;
           else
                $id = $this->insertID;
           if($this->_params["ChkProba"]->_value==0)
                $lezarva = ",hirlevel_lezarva=1";
            $query = "
                UPDATE {$this->_tableName}
                SET hirlevel_cimzett_szum={$cimzettek_szama},
                    hirlevel_kikuldve=0
                    {$lezarva}
                WHERE hirlevel_id='{$id}' 
                LIMIT 1
            ";
            $this->_DB->prepare($query)->query_update();
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
        }
    }
}
?>