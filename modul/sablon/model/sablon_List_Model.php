<?php
class sablon_List_Model extends Admin_List_Model {
    public $_tableName = "sablon";
    public $_fields = "sablon_id AS ID, sablon_nev AS elso";
    public $tableHeader = array(
            "sablon_nev" => array("label" => "Név", "width" => 100)
    );
}
?>