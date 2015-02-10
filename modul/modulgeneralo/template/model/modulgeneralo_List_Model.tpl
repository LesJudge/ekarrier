<?php
/**
 * {$publikusnev} List model.
 */
class {$modulnevUpper}_List_Model extends Admin_List_Model{
    
    public $_tableName = '{$tablanev}';
    
    public $_fields = '{$tablanev}_id AS ID,
                       {$tablanev}_nev AS elso,
                       {$tablanev}_aktiv AS Aktiv,
                       {$fields}
                       {$tablanev}_letrehozas_datum AS Letrehozva,
                       CASE WHEN {$tablanev}_modositas_datum != \'0000-00-00\' THEN {$tablanev}_modositas_datum ELSE \'Nem lett módosítva!\' END AS Modositva,
                       {$tablanev}_javitas_szama AS ModositasSzama';
    
    public $tableHeader  = array(
            '{$tablanev}_nev' => array('label' => 'Megnevezés', 'width' => 30),
            {$tableHeader}
            '{$tablanev}_letrehozas_datum' => array('label' => 'Létrehozás ideje'),
            '{$tablanev}_modositas_datum' => array('label' => 'Módosítás ideje'),
            '{$tablanev}_javitas_szama' => array('label' => 'Módosítások száma'),
            '{$tablanev}_aktiv' => array('label' => 'Közzétéve'),
    );
        
    public function __addForm(){
    	parent::__addForm();
        $this->addItem('FilterStatus')->_select_value = Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
    }
    
}
?>