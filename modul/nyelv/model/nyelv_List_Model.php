<?php
class Nyelv_List_Model extends Admin_List_Model {
    public $_tableName = "nyelv";
    public $_fields = "nyelv_id AS ID, nyelv_nev AS elso, nyelv_azon, 
                       nyelv_aktiv AS Aktiv, nyelv_zaszlo_nev
    ";
    public $tableHeader = array(
            "nyelv_nev" => array("label" => "Név", "width" => 70),
            "nyelv_azon" => array("label" => "Azonosító", "width" => 22),
            "nyelv_aktiv" => array("label" => "Státusz", "width" => 8)
    );
}
?>