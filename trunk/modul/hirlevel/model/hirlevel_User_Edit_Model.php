<?php
class Hirlevel_User_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "hirlevel_user";
    public $_bindArray = array("hirlevel_user_nev" => "TxtNev", 
                               "hirlevel_user_email" => "TxtEmail",
                               "hirlevel_nyelv_id_id" => "SelKapcsolatNyelv"
    );

    public function __addForm(){
        parent::__addForm();
        $this->addItem("TxtNev")->_verify["string"] = true;
        $email = $this->addItem("TxtEmail");
        $email->_verify["string"] = true;
        $email->_verify["email"] = true;
        $email->_verify["unique"] = array("table"=>"hirlevel_user","field"=>"hirlevel_user_email", "modify"=>$this->modifyID, "DB"=>$this->_DB);
        
        $kapcsolat_nyelve = $this->addItem("SelKapcsolatNyelv");
        $kapcsolat_nyelve->_select_value = $this->getSelectValues("nyelv","nyelv_nev","","",false);
        $kapcsolat_nyelve->_value = 1;
        
        $csoport = $this->addItem("SelCsoport");
        $csoport->_select_value = $this->csoportSelect();
    }
    
    private function csoportSelect(){
    	try
        {
            $list = array();
            $query = "
                SELECT hirlevel_csoport_id,
					   CONCAT(hirlevel_csoport_nev,' (',nyelv_nev,') ') AS nev 
                FROM hirlevel_csoport 
                INNER JOIN nyelv ON nyelv_id=hirlevel_csoport_nyelv_id 	
                WHERE hirlevel_csoport_torolt=0 
                ORDER BY hirlevel_csoport_nyelv_id ASC,  
                	     hirlevel_csoport_tipus DESC,
						 hirlevel_csoport_nev ASC
            ";
            $obj = $this->_DB->prepare($query)->query_select();
            while($adat = $obj->query_fetch_array()){
                $list[$adat["hirlevel_csoport_id"]] = $adat["nev"];
            }
            return $list;
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
      
    public function __newData(){
        parent::__newData();
    }
    
    public function __editData(){
        $query = "
            SELECT user_id,
                   DATE_FORMAT(hirlevel_user_feliratkozas,'%Y-%m-%d %H:%i') AS hirlevel_user_feliratkozas, 
                   DATE_FORMAT(hirlevel_user_leiratkozas,'%Y-%m-%d %H:%i') AS hirlevel_user_leiratkozas, 
                   hirlevel_user_leiratkozva
            FROM {$this->_tableName}
            WHERE hirlevel_user_id='{$this->modifyID}'
            LIMIT 1
        ";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
        
    public function __formValues(){
        parent::__formValues(); 
        $this->_params["SelCsoport"]->_value =  $this->getSelectAktivValues("hirlevel_user_attr_csoport");  
    }
    
    public function __update(){
        $this->saveSelect("hirlevel_user_attr_csoport", $this->_params["SelCsoport"]->_value, $this->modifyID);
        parent::__update();
    }
    
    public function __insert(){
        parent::__insert(",hirlevel_user_feliratkozas=now()");
        $this->saveSelect("hirlevel_user_attr_csoport", $this->_params["SelCsoport"]->_value, $this->insertID);  
    }
}
?>