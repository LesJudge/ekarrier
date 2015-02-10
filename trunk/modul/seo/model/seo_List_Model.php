<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Seo_List_Model extends Admin_List_Model
{

        public $_tableName='seo';
        public $_fields='seo.seo_id AS ID,
                                  seo_nev AS elso,
                                  seo_kulcs,
                                  IF(seo_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(seo_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  seo_create_date AS letrehozva,
                                  IF(seo_modositas_datum=0,\'Nem lett módosítva!\',seo_modositas_datum) AS modositva,
                                  seo_megtekintve,
                                  seo_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=seo_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=seo_modosito';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'seo_nev'=>array('label'=>'Név'),
                        'seo_kulcs'=>array('label'=>'Kulcs'),
                        'seo_letrehozo'=>array('label'=>'Létrehozó'),
                        'seo_letrehozva'=>array('label'=>'Létrehozás ideje'),
                        'seo_modosito'=>array('label'=>'Módosító'),
                        'seo_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'seo_megtekintve'=>array('label'=>'Megtekintve'),
                        'seo_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='seo_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}