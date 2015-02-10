<?php
class Beallitas_IparagList_Model extends Admin_List_Model
{

        public $_tableName='iparag';
        public $_fields='iparag.iparag_id AS ID,
                                  iparag_nev AS elso,
                                  IF(iparag_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(iparag_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  iparag_create_date AS letrehozva,
                                  IF(iparag_modositas_datum=0,\'Nem lett módosítva!\',iparag_modositas_datum) AS modositva,
                                  iparag_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=iparag_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=iparag_modosito';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'iparag_nev'=>array('label'=>'Név', 'width'=>42),
                        'iparag_letrehozo'=>array('label'=>'Létrehozó'),
                        'iparag_create_date'=>array('label'=>'Létrehozás ideje'),
                        'iparag_modosito'=>array('label'=>'Módosító'),
                        'iparag_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'iparag_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='iparag_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}