<?php
class Beallitas_Pozicio_Comment_List_Model extends Admin_List_Model
{

        public $_tableName = 'pozicio_hozzaszolas';
        public $_fields = 'pozicio_hozzaszolas.pozicio_hozzaszolas_id AS ID,
                                  p.pozicio_nev AS elso,
                                  CONCAT (ugyf.vezeteknev, \' \', ugyf.keresztnev) AS ugyfelnev,
                                  IF(pozicio_hozzaszolas.modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  IF(pozicio_hozzaszolas.modositas_datum = \'0000-00-00 00:00:00 \',\'Nem lett módosítva\',pozicio_hozzaszolas.modositas_datum) AS modositas_datum,
                                  pozicio_hozzaszolas.pozicio_hozzaszolas_aktiv AS Aktiv,
                                  IF(pozicio_hozzaszolas.checked = 0, \'Nincs leellenőrizve\', \'Ellenőrizve\') AS checked
                                   ';
        public $_join='LEFT JOIN pozicio p ON p.pozicio_id = pozicio_hozzaszolas.pozicio_id
                       LEFT JOIN user u2 ON u2.user_id = pozicio_hozzaszolas.modosito
                       LEFT JOIN ugyfel ugyf ON ugyf.ugyfel_id = pozicio_hozzaszolas.ugyfel_id';

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
                $this->_params['TxtSort']->_value='p.pozicio_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
                $this->addItem('FilterChecked')->_select_value = array("" => "Mind", "1" => "Nem ellenőrzött", "2" => "Ellenőrzött");
        }

}