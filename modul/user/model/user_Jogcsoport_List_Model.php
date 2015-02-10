<?php
class User_Jogcsoport_List_Model extends Admin_List_Model {
    public $_tableName = "jogcsoport";
    public $_fields = "jogcsoport_id AS ID, jogcsoport_nev AS elso, jogcsoport_aktiv AS Aktiv";
    public $tableHeader = array(
            "jogcsoport_nev" => array("label" => "Név", "width" => 92),
            "jogcsoport_aktiv" => array("label" => "Státusz", "width" => 8)
    );
    
    public function __addForm(){
        parent::__addForm();
        $tipus = $this->addItem('FilterTipus');
        $tipus->_select_value = $this->getSelectValues("site_tipus", "site_tipus_nev", "", "", false, array(0=>"--Válasszon oldal típust--"));
    }
}
?>