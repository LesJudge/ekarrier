<?php

class Varos_List_Model extends Admin_List_Model
{
    public $_tableName = 'cim_varos';
    
    public $_fields = 'cim_varos_id AS ID, cim_varos_nev AS elso, cim_varos_aktiv AS Aktiv';
    
    public $tableHeader = array(
        'cim_varos_nev' => array('label' => 'Megnevezés', 'width' => 80),
        'orszag_id' => array('label' => 'Ország', 'width' => 12),
        'cim_varos_aktiv' => array('label' => 'Közzétéve', 'width' => 8)
    );

    public function __addForm()
    {
        parent::__addForm();
        $this->_params['TxtSort']->_value = 'cim_varos_nev__ASC';
    }
}
