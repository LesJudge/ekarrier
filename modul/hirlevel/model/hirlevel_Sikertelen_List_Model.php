<?php
class Hirlevel_Sikertelen_List_Model extends Admin_List_Model {
    public $_tableName = "hirlevel_kikuldendo";
    public $_fields = "hirlevel_kikuldendo_id AS ID, hirlevel_user.hirlevel_user_nev AS nev,
                       hirlevel_kikuldendo.hirlevel_user_email AS email,  
                       hirlevel_targy,hirlevel_kikuldendo_probalkozas,hirlevel_kikuldendo_send_date 
	";
    public $_join = "LEFT JOIN hirlevel_user ON hirlevel_user.hirlevel_user_id=hirlevel_kikuldendo.hirlevel_user_id";
    public $tableHeader = array(
            "hirlevel_user.hirlevel_user_nev" => array("label" => "Címzett neve", "width" => 25),
            "hirlevel_kikuldendo.hirlevel_user_email" => array("label" => "Címzett e-mail", "width" => 25),
            "hirlevel_targy" => array("label" => "Hírlevél tárgya", "width" => 20),
            "hirlevel_kikuldendo_probalkozas" => array("label" => "Próbálkozások száma", "width" => 15),
            "hirlevel_kikuldendo_send_date" => array("label" => "Utolsó próbálkozás", "width" => 15)
    );
    public $listWhere = array("hirlevel_kikuldendo_probalkozas" => "hirlevel_kikuldendo_probalkozas>0",
                              "hirlevel_proba" => "hirlevel_proba=0"  
    );
    
    public function __addForm(){
        parent::__addForm();
        $this->_params["TxtSort"]->_value = "hirlevel_kikuldendo_send_date__DESC";
        $this->addItem("FilterHirlevel")->_select_value = $this->getSelectValues("hirlevel","hirlevel_targy","","",false,array(0=>"--Válasszon hírlevelet--"));
    }
    public function __createWhere(){
        $felt_array = implode(" AND ", $this->listWhere);
        $this->listWhere = " WHERE {$felt_array}";
    }
    
    public function deleteRow($id){
        $query = "
            DELETE FROM `{$this->_tableName}` 
            WHERE {$this->_tableName}_id=".mysql_real_escape_string($id)."
        ";
        if ($this->nyelvID) $query .= " AND nyelv_id={$this->nyelvID}";
        $query .= " LIMIT 1 ";
        $this->_DB->prepare($query)->query_update();
    }
}
?>