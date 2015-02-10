<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Infobox_List_Model extends Admin_List_Model
{

        public $_tableName='infobox';
        public $_fields='infobox.infobox_id AS ID,
                                  infobox_nev AS elso,
                                  infobox_kulcs,
                                  IF(infobox_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(infobox_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  infobox_create_date AS letrehozva,
                                  IF(infobox_modositas_datum=0,\'Nem lett módosítva!\',infobox_modositas_datum) AS modositva,
                                  infobox_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=infobox_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=infobox_modosito';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'infobox_nev'=>array('label'=>'Név'),
                        'infobox_kulcs'=>array('label'=>'Kulcs'),
                        'infobox_letrehozo'=>array('label'=>'Létrehozó'),
                        'infobox_letrehozva'=>array('label'=>'Létrehozás ideje'),
                        'infobox_modosito'=>array('label'=>'Módosító'),
                        'infobox_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'infobox_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='infobox_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}