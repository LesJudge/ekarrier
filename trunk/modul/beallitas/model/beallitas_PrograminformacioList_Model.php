<?php
class Beallitas_PrograminformacioList_Model extends Admin_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'program_informacio';
    /**
     * Kiválasztott mezők.
     * @var string
     */
    public $_fields = 'program_informacio.program_informacio_id AS ID,
                       program_informacio_nev AS elso,
                       letrehozas_timestamp,
                       modositas_timestamp,
                       modositas_szama,
                       program_informacio_aktiv AS Aktiv,
                       CONCAT(u1.user_vnev, \' \', u1.user_knev) AS letrehozo_nev,
                       CONCAT(u2.user_vnev, \' \', u2.user_knev) AS modosito_nev';
    /**
     * MySQL JOIN.
     * @var string
     */
    public $_join = 'LEFT JOIN user u1 ON letrehozo_id = u1.user_id
                     LEFT JOIN user u2 ON modosito_id = u2.user_id';
    /**
     * Elemek hozzáadása a formhoz.
     */
    public function __addForm()
    {
        parent::__addForm();
        $this->tableHeader=array(
            'program_informacio_nev' => array('label' => 'Név'),
            'u1.user_vnev' => array('label' => 'Létrehozó'),
            'letrehozas_timestamp' => array('label' => 'Létrehozás ideje'),
            'u2.user_vnev' => array('label' => 'Módosító'),
            'modositas_timestamp' => array('label' => 'Módosítás ideje'),
            'modositas_szama' => array('label' => 'Módosítás száma'),
            'program_informacio_aktiv' => array('label' => 'Közzétéve', 'width' => 8)
        );
        $this->_params['TxtSort']->_value='program_informacio_nev__ASC';
        $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
    }
}