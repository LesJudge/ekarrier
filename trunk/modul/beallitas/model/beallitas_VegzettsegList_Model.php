<?php
class Beallitas_VegzettsegList_Model extends Admin_List_Model
{

        public $_tableName='vegzettseg';
        public $_fields='vegzettseg.vegzettseg_id AS ID,
                                  nev AS elso,
                                  IF(letrehozo_id IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(modosito_id IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  letrehozas_timestamp AS letrehozva,
                                  IF(modositas_timestamp=0,\'Nem lett módosítva!\',modositas_timestamp) AS modositva,
                                  vegzettseg_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=letrehozo_id
                                LEFT JOIN user u2 ON u2.user_id=modosito_id';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'nev'=>array('label'=>'Név', 'width'=>42),
                        'letrehozo_id'=>array('label'=>'Létrehozó'),
                        'letrehozas_timestamp'=>array('label'=>'Létrehozás ideje'),
                        'modosito_id'=>array('label'=>'Módosító'),
                        'modositas_timestamp'=>array('label'=>'Módosítás ideje'),
                        'vegzettseg_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}