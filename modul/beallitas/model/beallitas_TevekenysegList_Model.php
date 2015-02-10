<?php
class Beallitas_TevekenysegList_Model extends Admin_List_Model
{

        public $_tableName='munkakor_tevekenyseg';
        public $_fields='munkakor_tevekenyseg.munkakor_tevekenyseg_id AS ID,
                                  munkakor_tevekenyseg_nev AS elso,
                                  IF(munkakor_tevekenyseg.munkakor_tevekenyseg_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                  IF(munkakor_tevekenyseg.munkakor_tevekenyseg_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  munkakor_tevekenyseg.munkakor_tevekenyseg_letrehozas_datum AS letrehozva,
                                  IF(munkakor_tevekenyseg.munkakor_tevekenyseg_modositas_datum=0,\'Nem lett módosítva!\',munkakor_tevekenyseg_modositas_datum) AS modositva,
                                  munkakor_tevekenyseg.munkakor_tevekenyseg_modositas_szama AS modositas_szama,
                                  munkakor_tevekenyseg.munkakor_tevekenyseg_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=munkakor_tevekenyseg_letrehozo
                                LEFT JOIN user u2 ON u2.user_id=munkakor_tevekenyseg_modosito';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'munkakor_tevekenyseg_nev'=>array(
                                'label'=>'Név',
                                'width'=>30
                        ),
                        'munkakor_tevekenyseg_letrehozo'=>array(
                                'label'=>'Létrehozó'
                        ),
                        'munkakor_tevekenyseg_letrehozas_datum'=>array(
                                'label'=>'Létrehozás ideje'
                        ),
                        'munkakor_tevekenyseg_modosito'=>array(
                                'label'=>'Módosító'
                        ),
                        'munkakor_tevekenyseg_modositas_datum'=>array(
                                'label'=>'Módosítás ideje'
                        ),
                        'munkakor_tevekenyseg_modositas_szama'=>array(
                                'label'=>'Módosítás száma'
                        ),
                        'munkakor_tevekenyseg_aktiv'=>array(
                                'label'=>'Közzétéve', 'width'=>8
                        )
                );
                $this->_params['TxtSort']->_value='munkakor_tevekenyseg_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
        }

}