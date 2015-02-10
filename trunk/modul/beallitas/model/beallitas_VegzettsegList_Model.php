<?php
class Beallitas_VegzettsegList_Model extends Admin_List_Model
{

        public $_tableName='vegzettseg';
        public $_fields='vegzettseg.vegzettseg_id AS ID,
                                  vegzettseg_nev AS elso,
                                  IF(vegzettseg_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(vegzettseg_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  vegzettseg_create_date AS letrehozva,
                                  IF(vegzettseg_modositas_datum=0,\'Nem lett módosítva!\',vegzettseg_modositas_datum) AS modositva,
                                  vegzettseg_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=vegzettseg_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=vegzettseg_modosito';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'vegzettseg_nev'=>array('label'=>'Név', 'width'=>42),
                        'vegzettseg_letrehozo'=>array('label'=>'Létrehozó'),
                        'vegzettseg_create_date'=>array('label'=>'Létrehozás ideje'),
                        'vegzettseg_modosito'=>array('label'=>'Módosító'),
                        'vegzettseg_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'vegzettseg_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='vegzettseg_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}