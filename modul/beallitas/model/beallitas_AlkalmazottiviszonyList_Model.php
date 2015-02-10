<?php
class Beallitas_AlkalmazottiviszonyList_Model extends Admin_List_Model
{

        public $_tableName='alkalmazottiviszony';
        public $_fields='alkalmazottiviszony.alkalmazottiviszony_id AS ID,
                                  alkalmazottiviszony_nev AS elso,
                                  IF(alkalmazottiviszony_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(alkalmazottiviszony_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  alkalmazottiviszony_create_date AS letrehozva,
                                  IF(alkalmazottiviszony_modositas_datum=0,\'Nem lett módosítva!\',alkalmazottiviszony_modositas_datum) AS modositva,
                                  alkalmazottiviszony_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=alkalmazottiviszony_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=alkalmazottiviszony_modosito';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'alkalmazottiviszony_nev'=>array('label'=>'Név', 'width'=>42),
                        'alkalmazottiviszony_letrehozo'=>array('label'=>'Létrehozó'),
                        'alkalmazottiviszony_create_date'=>array('label'=>'Létrehozás ideje'),
                        'alkalmazottiviszony_modosito'=>array('label'=>'Módosító'),
                        'alkalmazottiviszony_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'alkalmazottiviszony_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='alkalmazottiviszony_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}