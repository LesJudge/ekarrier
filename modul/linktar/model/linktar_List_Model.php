<?php
/**
 * Linktár List model.
 */
class Linktar_List_Model extends Admin_List_Model{
    
    public $_tableName = 'linktar';
    
    public $_fields = 'linktar_id AS ID,
                       linktar_cim AS elso,
                       linktar_aktiv AS Aktiv,
                       linktar_create_date AS Letrehozva,
                       CASE WHEN linktar_modositas_datum != \'0000-00-00\' THEN linktar_modositas_datum ELSE \'Nem lett módosítva!\' END AS Modositva,
                       linktar_javitas_szama AS ModositasSzama';
    
    public $tableHeader  = array(
            'linktar_cim' => array('label' => 'Megnevezés', 'width' => 30),
            'linktar_create_date' => array('label' => 'Létrehozás ideje'),
            'linktar_modositas_datum' => array('label' => 'Módosítás ideje'),
            'linktar_javitas_szama' => array('label' => 'Módosítások száma'),
            'linktar_aktiv' => array('label' => 'Közzétéve'),
    );
        
    public function __addForm(){
    	parent::__addForm();
        $this->addItem('FilterStatus')->_select_value = Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
    }
    
}
?>