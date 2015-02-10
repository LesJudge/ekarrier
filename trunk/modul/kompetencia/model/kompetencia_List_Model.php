<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Kompetencia_List_Model extends Admin_List_Model
{

        public $_tableName='kompetencia';
        public $_fields='kompetencia.kompetencia_id AS ID,
                                  kompetencia_nev AS elso,
                                  IF(kompetencia_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(kompetencia_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  kompetencia_create_date AS letrehozva,
                                  IF(kompetencia_modositas_datum=0,\'Nem lett módosítva!\',kompetencia_modositas_datum) AS modositva,
                                  kompetencia_megtekintve,
                                  kompetencia_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=kompetencia_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=kompetencia_modosito';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'kompetencia_nev'=>array('label'=>'Név', 'width'=>42),
                        'kompetencia_letrehozo'=>array('label'=>'Létrehozó'),
                        'kompetencia_letrehozva'=>array('label'=>'Létrehozás ideje'),
                        'kompetencia_modosito'=>array('label'=>'Módosító'),
                        'kompetencia_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'kompetencia_megtekintve'=>array('label'=>'Megtekintve'),
                        'kompetencia_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='kompetencia_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}