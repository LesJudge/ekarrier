<?php
class Hirlevel_User_List_Model extends Admin_List_Model {
    public $_tableName = "hirlevel_user";
    public $_fields = "hirlevel_user_id AS ID, hirlevel_user_nev AS elso, hirlevel_user_email, 
                        DATE_FORMAT(hirlevel_user_feliratkozas,'%Y-%m-%d %H:%i') AS hirlevel_user_feliratkozas, 
                        DATE_FORMAT(hirlevel_user_leiratkozas,'%Y-%m-%d %H:%i') AS hirlevel_user_leiratkozas
	";
    public $tableHeader = array(
            "hirlevel_user_nev" => array("label" => "Név", "width" => 35),
            "hirlevel_user_email" => array("label" => "E-mail", "width" => 35),
            "hirlevel_user_feliratkozas" => array("label" => "Feliratkozva", "width" => 15),
            "hirlevel_user_leiratkozas" => array("label" => "Leiratkozva", "width" => 15)
    );
    
    public function __addForm(){
        parent::__addForm();
        $this->_params["TxtSort"]->_value = "hirlevel_user_feliratkozas__DESC";
        $this->addItem("FilterTipus")->_select_value = array(
                                                            0=>"--Válasszon típust--",
                                                            1=>"Regisztrált személyek",
                                                            2=>"Nem regisztrált személyek",
                                                            3=>"Aktív személyek",
                                                            4=>"Leiratkozott személyek"
        );
        $this->addItem("FilterKapcsolat")->_select_value = $this->getSelectValues("nyelv", "nyelv_nev", "", "", false, array(0=>"--Válasszon kapcsolati nyelvet--"));
    }
    
     public function deleteRow($id){
        $query = "
            UPDATE `{$this->_tableName}`
            SET  {$this->_tableName}_torolt=1
            WHERE {$this->_tableName}_id=".mysql_real_escape_string($id)."
        ";
        if ($this->nyelvID) $query .= " AND nyelv_id={$this->nyelvID}";
        $query .= " LIMIT 1 ";
        $this->_DB->prepare($query)->query_update();
    }
    
    public function updateUser($id){
        $query = "
            SELECT 	user_id 
            FROM `{$this->_tableName}`
            WHERE {$this->_tableName}_id=".mysql_real_escape_string($id)."
        ";
        if ($this->nyelvID) $query .= " AND nyelv_id={$this->nyelvID}";
        $query .= " LIMIT 1 ";
        $user_id = $this->_DB->prepare($query)->query_select()->query_fetch_array("user_id");
        $query = "
            UPDATE user 
            SET user_hirlevel=0 
            WHERE user_id={$user_id}
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
    }
}
?>