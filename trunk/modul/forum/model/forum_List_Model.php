<?php
class Forum_List_Model extends Admin_List_Model {
    public $_tableName = "forum";
    public $_fields = "forum_id AS ID, forum_targy AS elso, forum_bekuldo, 
                       forum_bekuldve_date, forum_aktiv AS Aktiv
    ";
    public $tableHeader = array(
            "forum_targy" => array("label" => "Tárgy", "width" => 35),
            "forum_bekuldo" => array("label" => "Beküldő", "width" => 35),
            "forum_bekuldve_date" => array("label" => "Dátum", "width" => 20),
            "forum_aktiv" => array("label" => "Státusz", "width" => 10)
    );
    
    public function __addForm(){
        parent::__addForm();
        $this->_params["TxtSort"]->_value = "forum_bekuldve_date__DESC";
        $this->addItem('FilterNyelv')->_select_value = $this->getSelectValues("nyelv", "nyelv_nev", "","ORDER BY nyelv_nev",false,array(0=>"--Válasszon nyelvet--"));
    }    
}
?>