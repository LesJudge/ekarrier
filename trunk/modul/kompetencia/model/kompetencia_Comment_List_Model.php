<?php
class Kompetencia_Comment_List_Model extends Admin_List_Model
{

        public $_tableName = 'kompetencia_hozzaszolas';
        public $_fields = 'kompetencia_hozzaszolas.kompetencia_hozzaszolas_id AS ID,
                                  k.kompetencia_nev AS elso,
                                  CONCAT (ugyf.vezeteknev, \' \', ugyf.keresztnev) AS ugyfelnev,
                                  IF(kompetencia_hozzaszolas.modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  IF(kompetencia_hozzaszolas.modositas_datum = \'0000-00-00 00:00:00 \',\'Nem lett módosítva\',kompetencia_hozzaszolas.modositas_datum) AS modositas_datum,
                                  kompetencia_hozzaszolas.kompetencia_hozzaszolas_aktiv AS Aktiv';
        public $_join='LEFT JOIN kompetencia k ON k.kompetencia_id = kompetencia_hozzaszolas.kompetencia_id
                       LEFT JOIN user u2 ON u2.user_id = kompetencia_hozzaszolas.modosito
                       LEFT JOIN ugyfel ugyf ON ugyf.ugyfel_id = kompetencia_hozzaszolas.ugyfel_id';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'kompetencia_nev'=>array('label'=>'Név', 'width'=>42),
                        'ugyfelnev'=>array('label'=>'Ügyfél'),
                        'modosito'=>array('label'=>'Módosító'),
                        'modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'Aktiv'=>array('label'=>'Közzétéve'),
                );
                $this->_params['TxtSort']->_value='k.kompetencia_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}