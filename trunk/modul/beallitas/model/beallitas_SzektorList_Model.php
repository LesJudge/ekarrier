<?php
class Beallitas_SzektorList_Model extends Admin_List_Model
{

        public $_tableName='szektor';
        public $_fields='szektor.szektor_id AS ID,
                                  szektor_nev AS elso,
                                  IF(szektor_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(szektor_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  szektor_create_date AS letrehozva,
                                  IF(szektor_modositas_datum=0,\'Nem lett módosítva!\',szektor_modositas_datum) AS modositva,
                                  szektor_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=szektor_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=szektor_modosito';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'szektor_nev'=>array('label'=>'Név', 'width'=>42),
                        'szektor_letrehozo'=>array('label'=>'Létrehozó'),
                        'szektor_create_date'=>array('label'=>'Létrehozás ideje'),
                        'szektor_modosito'=>array('label'=>'Módosító'),
                        'szektor_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'szektor_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='szektor_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}