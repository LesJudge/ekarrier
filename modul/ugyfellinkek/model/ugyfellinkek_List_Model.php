<?php
class Ugyfellinkek_List_Model extends Admin_List_Model
{

        public $_tableName='ugyfel_attr_linkek';
        public $_fields='ugyfel_attr_linkek_id AS ID,
                                  link_nev AS elso,
                                  category AS kat,
                                  IF(ugyfel_attr_linkek.letrehozo_id IS NULL,
                                            \'Ismeretlen\',
                                                IF(tipus = \'ugyfel\',
                                                CONCAT(ugyfel.vezeteknev,\' \',ugyfel.keresztnev)
                                                ,
                                                CONCAT(u1.user_vnev,\' \',u1.user_knev)
                                                )
                                                ) AS letrehozo,
                                  IF(ugyfel_attr_linkek.modosito_id IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                  ugyfel_attr_linkek.letrehozas_timestamp AS letrehozva,
                                  IF(ugyfel_attr_linkek.modositas_timestamp=0,\'Nem lett módosítva!\',ugyfel_attr_linkek.modositas_timestamp) AS modositva,
                                  IF(tipus = \'sajat\',\'Saját\',
                                        IF(checked = 0, \'Nincs leellenőrizve\', \'Ellenőrizve\')
                                      ) AS checked,
                                  ugyfel_attr_linkek_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u1 ON u1.user_id=letrehozo_id
                                LEFT JOIN user u2 ON u2.user_id=modosito_id
                                LEFT JOIN ugyfel ON ugyfel.ugyfel_id = ugyfel_attr_linkek.letrehozo_id
';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'link_nev'=>array('label'=>'Név', 'width'=>20),
                        'letrehozo'=>array('label'=>'Létrehozó'),
                        'kat'=>array('label'=>'Kategória'),
                        'checked'=>array('label'=>'Ellenőrizve'),
                        'letrehozva'=>array('label'=>'Létrehozás ideje'),
                        'modosito'=>array('label'=>'Módosító'),
                        'modositva'=>array('label'=>'Módosítás ideje'),
                        'Aktiv'=>array('label'=>'Közzétéve', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='link_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
                //$this->addItem('FilterType')->_select_value = array("" => "Mind", "1" => "Saját", "2" => "Ügyfél");
                $this->addItem('FilterChecked')->_select_value = array("" => "Mind", "1" => "Nem ellenőrzött", "2" => "Ellenőrzött");
                $this->addItem('FilterCat')->_select_value = array("" => "Mind", "kompetencia" => "Kompetencia", "szektor" => "Szektor", "pozicio" => "Pozíció");
        }

}