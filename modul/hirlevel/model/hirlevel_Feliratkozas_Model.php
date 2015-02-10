<?php
class Hirlevel_Feliratkozas_Model extends Admin_Edit_Model {
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
        $kapcsolat_nyelve->_value = Rimo::$_config->SITE_NYELV_ID;
    }
      
    public function __insert($sets = ''){
        parent::__insert(",hirlevel_user_feliratkozas=now()");
		try{
			$query = "
				SELECT hirlevel_csoport_id 	
				FROM hirlevel_csoport
				WHERE hirlevel_csoport_tipus='hirlevel' AND 
					  hirlevel_csoport_tipus_nyelv=".Rimo::$_config->SITE_NYELV_ID." 
		  	    LIMIT 1
			";  
			$csoport_id = $this->_DB->prepare($query)->query_select()->query_fetch_array("hirlevel_csoport_id");
			
	        $query = "
	        	INSERT INTO hirlevel_user_attr_csoport 
	        	SET hirlevel_user_id={$this->insertID}, 
					hirlevel_user_attr_csoport_id={$csoport_id}
			";
			$this->_DB->prepare($query)->query_insert();
		}
		catch(Exception_MYSQL $e){
		}
    }
}
?>