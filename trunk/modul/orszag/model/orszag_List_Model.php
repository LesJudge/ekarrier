<?php
class Orszag_List_Model extends Admin_List_Model {
    public $_tableName = "orszag";
    public $_fields = "orszag_id AS ID, orszag_nev AS elso,
                       orszag_rovidites, orszag_aktiv AS Aktiv                       
    ";
    public $tableHeader  = array(
            "orszag_nev" => array("label" => "Megnevezés", "width" => 80),
            "orszag_rovidites" => array("label" => "Rövidítés", "width" => 12),
            "orszag_aktiv" => array("label" => "Közzétéve", "width" => 8)
    );
        
    public function __addForm(){
    	parent::__addForm();
    	$this->_params["TxtSort"]->_value = "orszag_nev__ASC";
    }
}
?>