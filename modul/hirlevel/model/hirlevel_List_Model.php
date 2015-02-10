<?php
class Hirlevel_List_Model extends Admin_List_Model {
    public $_tableName = "hirlevel";
    public $_fields = "hirlevel.hirlevel_id AS ID, hirlevel.hirlevel_targy AS elso, hirlevel.hirlevel_felado_nev, 
                        hirlevel.hirlevel_felado_email,
                        hirlevel_cimzett_szum,hirlevel_kikuldve, hirlevel_megnyitva,
                        DATE_FORMAT(hirlevel_kuldes_datum,'%Y-%m-%d %H:%i') AS hirlevel_kuldes_datum, 
                        COUNT(hirlevel_kikuldendo_id) AS kikuldetlen
    ";
    public $_join = "LEFT JOIN hirlevel_kikuldendo ON hirlevel_kikuldendo.hirlevel_id=hirlevel.hirlevel_id AND hirlevel_kikuldendo_probalkozas>0";
    public $tableHeader = array(
            "hirlevel.hirlevel_targy" => array("label" => "Tárgy", "width" => 25),
            "hirlevel.hirlevel_felado_nev" => array("label" => "Feladó név", "width" => 15),
            "hirlevel.hirlevel_felado_email" => array("label" => "Feladó e-mail", "width" => 15),
            "hirlevel_cimzett_szum" => array("label" => "Címzett (db)", "width" => 8),
            "hirlevel_kikuldve" => array("label" => "Kiküldve (db)", "width" => 8),
            "hirlevel_megnyitva" => array("label" => "Megnyitva (db)", "width" => 8),
            "hirlevel.hirlevel_kuldes_datum" => array("label" => "Kiküldés dátuma", "width" => 10),
            "kikuldetlen" => array("label" => "Sikertelen kiküldés", "width" => 15)
    );
    
    public function __addForm(){
        parent::__addForm();
        $this->_params["TxtSort"]->_value = "hirlevel.hirlevel_kuldes_datum__DESC";
        $this->addItem("FilterTipus")->_select_value = array(
                                                            0=>"--Válasszon típust--",
                                                            1=>"Kiküldve",
                                                            2=>"Éles kiküldve",
                                                            3=>"Próba kiküldve",
                                                            4=>"Nincs kikuldve",
                                                            5=>"Próba",
                                                            6=>"Éles"
        );
    }
}
?>