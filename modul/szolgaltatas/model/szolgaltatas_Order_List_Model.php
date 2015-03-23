<?php
class Szolgaltatas_Order_List_Model extends Admin_List_Model
{
    /**
     * Tábla neve.
     * @var string
     */
    public $_tableName = 'ceg_szolgaltatas_megrendeles';
    /**
     * Kiválasztott mezők.
     * @var string
     */
    public $_fields = 'ceg_szolgaltatas_megrendeles_id AS ID,
                       IF(c.nev IS NULL, \'Ismeretlen\',c.nev) AS elso,
                       megrendeles_timestamp AS letrehozva,
                       IF(statusz =0,\'Függőben\',\'Feldolgozva\') AS statusz,
                       ceg_szolgaltatas_megrendeles_aktiv AS Aktiv,
                       IF(ceg_szolgaltatas_megrendeles.modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                       IF(ceg_szolgaltatas_megrendeles.modositas_datum = \'0000-00-00 00:00:00 \',\'Nem lett módosítva\',ceg_szolgaltatas_megrendeles.modositas_datum) AS modositva';
    /**
     * MySQL JOIN.
     * @var string
     */
    public $_join = 'LEFT JOIN user u2 ON modosito = u2.user_id
                     LEFT JOIN ceg c ON c.ceg_id = ceg_szolgaltatas_megrendeles.ceg_id';
    /**
     * Elemek hozzáadása a formhoz.
     */
    public function __addForm()
    {
        parent::__addForm();
        $this->tableHeader=array(
            'elso' => array('label' => 'Cég'),
            'statusz' => array('label' => 'Státusz'),
            'letrehozva' => array('label' => 'Létrehozás ideje'),
            'modosito' => array('label' => 'Módosító'),
            'modositva' => array('label' => 'Módosítás ideje'),
            'Aktiv' => array('label' => 'Közzétéve', 'width' => 8)
        );
        $this->_params['TxtSort']->_value='elso__ASC';
        $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        $this->addItem('FilterOrderStatusz')->_select_value = array(''=>'Mind','1'=>'Függőben','2'=>'Feldolgozva');
    }
}