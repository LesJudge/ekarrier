<?php
class User_cim_List_Model extends Admin_List_Model {
    public $_tableName = "user_attr_cim";
    public $_fields = "user_attr_cim_id AS ID, user_attr_cim_nev AS elso, user_attr_cim_email,	user_attr_cim_tel, user_attr_cim_fax, user_attr_cim_tipus	
    ";
    
    public $tableHeader = array(
            "user_attr_cim_nev" => array("label" => "Név / Cégnév", "width" => 30),
            "user_attr_cim_tipus" => array("label" => "Típus", "width" => 15),
            "user_attr_cim_email" => array("label" => "E-mail cím", "width" => 20),
            "user_attr_cim_tel" => array("label" => "Telefonszám", "width" => 20),
            "user_attr_cim_fax" => array("label" => "Fax", "width" => 15)
    );
    public function __addForm(){
        parent::__addForm();
        $this->addItem("FilterTipus")->_select_value = Rimo::$_config->CIM_TIPUS;
    }
    
    public function getNev($user_id){
		$query = "
    		SELECT CONCAT(user_vnev,' ',user_knev) AS nev 
    		FROM user
    		WHERE user_id={$user_id}
    		LIMIT 1
		";
		return $this->_DB->prepare($query)->query_select()->query_fetch_array("nev");
    }
}
?>