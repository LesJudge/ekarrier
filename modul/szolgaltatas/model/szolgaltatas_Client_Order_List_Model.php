<?php
class Szolgaltatas_Client_Order_List_Model extends Admin_List_Model
{
    
    public $_tableName = 'ugyfel_szolgaltatas_megrendeles';
    
    public $_fields = 'ugyfel_szolgaltatas_megrendeles_id AS ID,
                       IF(u.ugyfel_id IS NULL, \'Ismeretlen\',CONCAT(u.vezeteknev,\' \',u.keresztnev)) AS elso,
                       megrendeles_timestamp AS letrehozva,
                       IF(statusz =0,\'Függőben\',\'Feldolgozva\') AS statusz,
                       ugyfel_szolgaltatas_megrendeles_aktiv AS Aktiv,
                       IF(ugyfel_szolgaltatas_megrendeles.modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                       IF(ugyfel_szolgaltatas_megrendeles.modositas_datum = \'0000-00-00 00:00:00 \',\'Nem lett módosítva\',ugyfel_szolgaltatas_megrendeles.modositas_datum) AS modositva';
    
    public $_join = 'LEFT JOIN user u2 ON modosito = u2.user_id
                     LEFT JOIN ugyfel u ON u.ugyfel_id = ugyfel_szolgaltatas_megrendeles.ugyfel_id';
    
    public function __addForm()
    {
        parent::__addForm();
        $this->tableHeader=array(
            'elso' => array('label' => 'Ügyfél'),
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