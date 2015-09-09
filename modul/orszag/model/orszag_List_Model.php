<?php

class Orszag_List_Model extends Admin_List_Model
{
    public $_tableName = 'cim_orszag';
    
    public $_fields = 'cim_orszag_id AS ID, nev AS elso, kod AS iso, cim_orszag_aktiv AS Aktiv';
    
    public $tableHeader = array(
        'nev' => array('label' => 'Megnevezés', 'width' => 80),
        'kod' => array('label' => 'ISO kód', 'width' => 12),
        'cim_orszag_aktiv' => array('label' => 'Közzétéve', 'width' => 8)
    );

    public function __addForm()
    {
        parent::__addForm();
        $this->_params['TxtSort']->_value = 'nev__ASC';
    }
}
