<?php
class Nyelvtudas_NyelvList_Model extends Admin_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'nyelvtudas_nyelv';
    /**
     * Kiválasztott mezők.
     * @var string
     */
    public $_fields = 'nyelvtudas_nyelv.nyelvtudas_nyelv_id AS ID,
                       nev AS elso,
                       letrehozas_timestamp,
                       modositas_timestamp,
                       modositas_szama,
                       nyelvtudas_nyelv_aktiv AS Aktiv,
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
            'nev' => array('label' => 'Név'),
            'u1.user_vnev' => array('label' => 'Létrehozó'),
            'letrehozas_timestamp' => array('label' => 'Létrehozás ideje'),
            'u2.user_vnev' => array('label' => 'Módosító'),
            'modositas_timestamp' => array('label' => 'Módosítás ideje'),
            'modositas_szama' => array('label' => 'Módosítás száma'),
            'nyelvtudas_nyelv_aktiv' => array('label' => 'Közzétéve', 'width' => 8)
        );
        $this->_params['TxtSort']->_value='nev__ASC';
        $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
    }
}