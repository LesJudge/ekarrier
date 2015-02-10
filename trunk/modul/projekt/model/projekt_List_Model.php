<?php

class Projekt_List_Model extends Admin_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'projekt';
    /**
     * Kiválasztott mezők.
     * @var string
     */
    public $_fields = 'projekt.projekt_id AS ID,
                       projekt.nev AS elso,
                       projekt.letrehozas_timestamp,
                       projekt.modositas_timestamp,
                       projekt.modositas_szama,
                       projekt.projekt_aktiv AS Aktiv,
                       CONCAT(u1.user_vnev, \' \', u1.user_knev) AS letrehozo_nev,
                       CONCAT(u2.user_vnev, \' \', u2.user_knev) AS modosito_nev';
    /**
     * MySQL JOIN.
     * @var string
     */
    public $_join = 'LEFT JOIN user u1 ON projekt.letrehozo_id = u1.user_id
                     LEFT JOIN user u2 ON projekt.modosito_id = u2.user_id';
    /**
     * Elemek hozzáadása a formhoz.
     */
    public function __addForm()
    {
        parent::__addForm();
        $this->tableHeader=array(
            'projekt.nev' => array('label' => 'Név'),
            'u1.user_vnev' => array('label' => 'Létrehozó'),
            'projekt.letrehozas_timestamp' => array('label' => 'Létrehozás ideje'),
            'u2.user_vnev' => array('label' => 'Módosító'),
            'projekt.modositas_timestamp' => array('label' => 'Módosítás ideje'),
            'projekt.modositas_szama' => array('label' => 'Módosítás száma'),
            'projekt.projekt_aktiv' => array('label' => 'Közzétéve', 'width' => 8)
        );
        $this->_params['TxtSort']->_value = 'projekt.nev__ASC';
        $this->addItem('FilterStatus')->_select_value = Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
    }
}