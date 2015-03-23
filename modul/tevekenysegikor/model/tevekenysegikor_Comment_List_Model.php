<?php
class Tevekenysegikor_Comment_List_Model extends Admin_List_Model
{

        public $_tableName = 'tevekenysegikor_hozzaszolas';
        public $_fields = 'tevekenysegikor_hozzaszolas.tevekenysegikor_hozzaszolas_id AS ID,
                                  mk.kategoria_cim AS elso,
                                  CONCAT (ugyf.vezeteknev, \' \', ugyf.keresztnev) AS ugyfelnev,
                                  IF(tevekenysegikor_hozzaszolas.modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  IF(tevekenysegikor_hozzaszolas.modositas_datum = \'0000-00-00 00:00:00 \',\'Nem lett módosítva\',tevekenysegikor_hozzaszolas.modositas_datum) AS modositas_datum,
                                  tevekenysegikor_hozzaszolas.tevekenysegikor_hozzaszolas_aktiv AS Aktiv,
                                  IF(tevekenysegikor_hozzaszolas.checked = 0, \'Nincs leellenőrizve\', \'Ellenőrizve\') AS checked                                  
                            ';
        public $_join='LEFT JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = tevekenysegikor_hozzaszolas.tevekenysegikor_id
                       LEFT JOIN user u2 ON u2.user_id = tevekenysegikor_hozzaszolas.modosito
                       LEFT JOIN ugyfel ugyf ON ugyf.ugyfel_id = tevekenysegikor_hozzaszolas.ugyfel_id';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'kategoria_cim'=>array('label'=>'Név', 'width'=>20),
                        'ugyfelnev'=>array('label'=>'Ügyfél'),
                        'checked'=>array('label'=>'Ellenőrizve'),
                        'modosito'=>array('label'=>'Módosító'),
                        'modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'Aktiv'=>array('label'=>'Közzétéve')
                );
                $this->_params['TxtSort']->_value='mk.kategoria_cim__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
                $this->addItem('FilterChecked')->_select_value = array("" => "Mind", "1" => "Nem ellenőrzött", "2" => "Ellenőrzött");
        }

}