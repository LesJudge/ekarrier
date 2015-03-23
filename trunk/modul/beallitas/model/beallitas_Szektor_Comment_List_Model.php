<?php
class Beallitas_Szektor_Comment_List_Model extends Admin_List_Model
{

        public $_tableName = 'szektor_hozzaszolas';
        public $_fields = 'szektor_hozzaszolas.szektor_hozzaszolas_id AS ID,
                                  sz.szektor_nev AS elso,
                                  CONCAT (ugyf.vezeteknev, \' \', ugyf.keresztnev) AS ugyfelnev,
                                  IF(szektor_hozzaszolas.modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  IF(szektor_hozzaszolas.modositas_datum = \'0000-00-00 00:00:00 \',\'Nem lett módosítva\',szektor_hozzaszolas.modositas_datum) AS modositas_datum,
                                  szektor_hozzaszolas.szektor_hozzaszolas_aktiv AS Aktiv,
                                  IF(szektor_hozzaszolas.checked = 0, \'Nincs leellenőrizve\', \'Ellenőrizve\') AS checked
                                   ';
        public $_join='LEFT JOIN szektor sz ON sz.szektor_id = szektor_hozzaszolas.szektor_id
                       LEFT JOIN user u2 ON u2.user_id = szektor_hozzaszolas.modosito
                       LEFT JOIN ugyfel ugyf ON ugyf.ugyfel_id = szektor_hozzaszolas.ugyfel_id';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'pozicio_nev'=>array('label'=>'Név', 'width'=>20),
                        'ugyfelnev'=>array('label'=>'Ügyfél'),
                        'checked'=>array('label'=>'Ellenőrizve'),
                        'modosito'=>array('label'=>'Módosító'),
                        'modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'Aktiv'=>array('label'=>'Közzétéve')
                );
                $this->_params['TxtSort']->_value='sz.szektor_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
                $this->addItem('FilterChecked')->_select_value = array("" => "Mind", "1" => "Nem ellenőrzött", "2" => "Ellenőrzött");
        }

}