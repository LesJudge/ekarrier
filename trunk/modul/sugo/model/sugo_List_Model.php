<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Sugo_List_Model extends Admin_List_Model
{

        public $_tableName='sugo';
        public $_fields='sugo.sugo_id AS ID,
                                  sugo_nev AS elso,
                                  IF(sugo_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(sugo_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  sugo_create_date AS letrehozva,
                                  IF(sugo_modositas_datum=0,\'Nem lett módosítva!\',sugo_modositas_datum) AS modositva,
                                  sugo_megtekintve,
                                  sugo_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=sugo_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=sugo_modosito';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'sugo_id'=>array('label'=>'Azonosító'),
                        'sugo_nev'=>array('label'=>'Név', 'width'=>42),
                        'sugo_letrehozo'=>array('label'=>'Létrehozó'),
                        'sugo_letrehozva'=>array('label'=>'Létrehozás ideje'),
                        'sugo_modosito'=>array('label'=>'Módosító'),
                        'sugo_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'sugo_megtekintve'=>array('label'=>'Megtekintve'),
                        'sugo_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='sugo_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}