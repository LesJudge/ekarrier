<?php
class Ugyfeluzenetek_List_Model extends Admin_List_Model
{

        public $_tableName = 'ugyfel_attr_uzenetek';
        public $_fields = 'ugyfel_attr_uzenetek.ugyfel_attr_uzenetek_id AS ID,
                           uzenet AS elso,
                           IF(uzenet_elolvasva = 1,\'Elolvasva\',\'Nincs elolvasva\') AS seen,
                           CONCAT (ugyf.vezeteknev, \' \', ugyf.keresztnev) AS ugyfelnev,
                           IF(ugyfel_attr_uzenetek.szerzo = \'ugyfel\',CONCAT (ugyf.vezeteknev, \' \', ugyf.keresztnev),CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS szerzo,
                           ugyfel_attr_uzenetek.bekuldes_datum AS datum,
                           ugyfel_attr_uzenetek.ugyfel_attr_uzenetek_aktiv AS Aktiv';
        public $_join='LEFT JOIN user u2 ON u2.user_id = ugyfel_attr_uzenetek.szerzo
                       LEFT JOIN ugyfel ugyf ON ugyf.ugyfel_id = ugyfel_attr_uzenetek.ugyfel_id';

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'uzenet'=>array('label'=>'Üzenet', 'width'=>30),
                        'szerzo'=>array('label'=>'Szerző'),
                        'ugyfelnev'=>array('label'=>'Ügyfél'),
                        'datum'=>array('label'=>'Beküldve'),
                        'seen'=>array('label'=>'Elolvasva'),
                        'Aktiv'=>array('label'=>'Ügyfélnek megjelenik'),
                );
                $this->_params['TxtSort']->_value='uzenet__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
                $this->addItem('FilterSeen')->_select_value=array("" =>"--Válasszon--", "1"=>"Olvasott", "2"=>"Nem olvasott");
                $this->addItem('FilterTarget')->_select_value=array("" =>"--Válasszon--", "1"=>"Bejövő", "2"=>"Kimenő");
        }

}