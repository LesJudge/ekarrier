<?php
class hozzaszolas_List_Model extends Admin_List_Model {
    public $_fields = "hozzaszolas_bekuldo as elso, DATE_FORMAT(hozzaszolas_bekuldve_date,'%Y-%m-%d %H:%i') AS bekuldve,
                       baloldal, jobboldal, szint, IF(LENGTH(hozzaszolas_tartalom)>465, CONCAT(SUBSTR(hozzaszolas_tartalom,1,465),'...'),hozzaszolas_tartalom) AS hozzaszolas_tartalom_min,
                       IF(checked = 0, 'Nincs leellenőrizve', 'Ellenőrizve') AS checked                                  
    ";
    public $tableHeader = array(
            "hozzaszolas_bekuldo" => array("label" => "Beküldő", "width" => 20),
            'checked'=>array('label'=>'Ellenőrizve'),
            "hozzaszolas_tartalom_min" => array("label" => "Tartalom", "width" => 62),
            "hozzaszolas_bekuldve_date" => array("label" => "Dátum", "width" => 10),
    );
    
    public function __addForm(){
    	$this->_fields .= " ,{$this->_tableName}_id AS ID, {$this->_tableName}_aktiv AS Aktiv";
    	$this->tableHeader[$this->_tableName."_aktiv"] = array("label" => "Státusz", "width" => 8);
    	
        parent::__addForm();
        $this->_params["TxtSort"]->_value = "hozzaszolas_bekuldve_date__DESC";
        $this->addItem('FilterNyelv')->_select_value = $this->getSelectValues("nyelv", "nyelv_nev", "","ORDER BY nyelv_nev",false,array(0=>"--Válasszon nyelvet--"));
        $kapcsolodo = str_replace("_hozzaszolas","",$this->_tableName);
        $this->addItem('FilterKapcsolodo')->_select_value = $this->getSelectValues($kapcsolodo, "{$kapcsolodo}_targy", "","ORDER BY {$kapcsolodo}_bekuldve_date DESC",false,array(0=>"--Válasszon témát--"));
        $this->addItem('FilterChecked')->_select_value = array("" => "Mind", "1" => "Nem ellenőrzött", "2" => "Ellenőrzött");
    }    
}
?>