<?php
class Hirlevel_Probauser_List_Model extends Admin_List_Model {
    public $_tableName = "hirlevel_probauser";
    public $_fields = "hirlevel_probauser_id AS ID, hirlevel_probauser_nev AS elso, hirlevel_probauser_email";
    public $tableHeader = array(
            "hirlevel_probauser_nev" => array("label" => "Név", "width" => 65),
            "hirlevel_probauser_email" => array("label" => "E-mail", "width" => 35),
    );
}
?>