<?php
class User_cim_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "user_attr_cim";
    public $_bindArray = array(
							"user_attr_cim_tipus" => "SelTipus",
							"user_attr_cim_nev" => "TxtNev",
							"user_attr_cim_email" => "TxtEmail",
							"user_attr_cim_tel" => "TxtTelefon",
							"user_attr_cim_fax" => "TxtFax",
							"user_attr_cim_orszag" => "SelOrszag",
							"user_attr_cim_irszam" => "TxtIrszag",
							"user_attr_cim_varos" => "TxtVaros",
							"user_attr_cim_utca_haz" => "TxtUtcaHaz"
    );
    public $_user_id;

    public function __addForm(){
    	$tipus = $this->addItem("SelTipus");
    	$tipus->_select_value = Rimo::$_config->CIM_TIPUS_EDIT;
    	$tipus->_verify["select"] = true;
    	$this->addItem("TxtNev")->_verify["string"] = true;
    	$email = $this->addItem("TxtEmail");
		$email->_verify["string"] = true;
		$email->_verify["email"] = true;
    	$this->addItem("TxtTelefon")->_verify["string"] = true;
    	$this->addItem("TxtFax");
    	$orszag = $this->addItem("SelOrszag");
    	$orszag->_select_value = $this->getSelectValues("orszag", "orszag_nev", "", "ORDER BY orszag_nev");
    	$orszag->_verify["select"] = true;
    	$this->addItem("TxtIrszag")->_verify["string"] = true;
    	$this->addItem("TxtVaros")->_verify["string"] = true;
    	$this->addItem("TxtUtcaHaz")->_verify["string"] = true;
    }
    
    public function __editData(){
        $query = "
            SELECT  user_id,
					CONCAT(user_vnev,' ',user_knev) AS user_nev
            FROM user
            INNER JOIN {$this->_tableName} ON user.user_id={$this->_tableName}.user_attr_user_id
            WHERE user_id='{$this->_user_id}' AND
            	  {$this->_tableName}.{$this->_tableName}_id={$this->modifyID}
            LIMIT 1
        ";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        return $data;
    }
    
    public function __newData(){
        parent::__newData();
        $this->_params["SelOrszag"]->_value = 124;
    }
    
    public function __update($sets=""){
        parent::__update("{$sets}, user_attr_user_id=".$this->_user_id);            
    }
    
    public function __insert($sets=""){
        parent::__insert("{$sets}, user_attr_user_id=".$this->_user_id);
    }
}
?>