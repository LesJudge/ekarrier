<?php
class Beallitas_AllashirdetesElonyList_Model extends Admin_List_Model
{

        public $_tableName='allashirdetes_elony';
        public $_fields='allashirdetes_elony.allashirdetes_elony_id AS ID,
                                  allashirdetes_elony_nev AS elso,
                                  IF(allashirdetes_elony.allashirdetes_elony_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(allashirdetes_elony.allashirdetes_elony_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  allashirdetes_elony.allashirdetes_elony_letrehozas_datum AS letrehozva,
                                  IF(allashirdetes_elony.allashirdetes_elony_modositas_datum=0,\'Nem lett módosítva!\',allashirdetes_elony_modositas_datum) AS modositva,
                                  allashirdetes_elony.allashirdetes_elony_modositas_szama AS modositas_szama,
                                  COUNT(ahme.allashirdetes_id) AS szerepel,
                                  allashirdetes_elony.allashirdetes_elony_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=allashirdetes_elony_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=allashirdetes_elony_modosito
                                LEFT JOIN allashirdetes_has_many_elony ahme ON allashirdetes_elony.allashirdetes_elony_id=ahme.allashirdetes_elony_id';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'allashirdetes_elony_nev'=>array(
                                'label'=>'Név',
                                'width'=>30
                        ),
                        'ahme.allashirdetes_id'=>array(
                                'label'=>'Szerepel'
                        ),
                        'allashirdetes_elony_letrehozo'=>array(
                                'label'=>'Létrehozó'
                        ),
                        'allashirdetes_elony_letrehozas_datum'=>array(
                                'label'=>'Létrehozás ideje'
                        ),
                        'allashirdetes_elony_modosito'=>array(
                                'label'=>'Módosító'
                        ),
                        'allashirdetes_elony_modositas_datum'=>array(
                                'label'=>'Módosítás ideje'
                        ),
                        'allashirdetes_elony_modositas_szama'=>array(
                                'label'=>'Módosítás száma'
                        ),
                        'allashirdetes_elony_aktiv'=>array(
                                'label'=>'Közzétéve', 'width'=>8
                        )
                );
                $this->_params['TxtSort']->_value='allashirdetes_elony_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}