<?php
include_once "modul/kategoria/model/kategoria_Master_List_Model.php";
class Menu_List_Model extends Kategoria_Master_List_Model {
    public $tableHeader = array(
                            "menu_nev" => array("label" => "Név", "width" => 80),
                            "jobb_testver" => array("label" => "Sorrend", "width" => 10),
                            "menu_aktiv" => array("label" => "Közzétéve", "width" => 8),
                            "menu_torolt" => array("label" => "Törlés", "width" => 8)
    );
    public $_fields = "node.menu_id AS ID,node.menu_nev AS elso, 
                node.menu_aktiv AS Aktiv, node.jobboldal-node.baloldal AS leaves, node.menu_link AS menu_link,node.szint
	";
}
?>