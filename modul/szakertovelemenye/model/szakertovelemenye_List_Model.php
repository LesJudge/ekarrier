<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Szakertovelemenye_List_Model extends Admin_List_Model
{

        public $_tableName='szakertovelemenye';
        public $_fields='szakertovelemenye_id AS ID,
                                 CONCAT(ugyf.vezeteknev,\' \',ugyf.keresztnev) AS elso,
                                 kr.kompetenciarajz_nev AS komprajzNev,
                                  IF(valaszolo_id = 0,\'Még nincs válasz\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS valaszolo,
                                  hozzaadas_date AS hozzaadva,
                                  IF(valasz_date=\'0000-00-00 00:00:00\',\'Nem lett megválaszolva!\',valasz_date) AS megvalaszolva';
        public $_join='INNER JOIN ugyfel ugyf ON ugyf.ugyfel_id = szakertovelemenye.ugyfel_id
                        INNER JOIN kompetenciarajz kr ON kr.kompetenciarajz_id = szakertovelemenye.kompetenciarajz_id
                        LEFT JOIN user u1 ON u1.user_id=szakertovelemenye.valaszolo_id';
        
        //public $listWhere;

        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'elso'=>array('label'=>'Név'),
                        'komprajzNev'=>array('label'=>'Kompetenciarajz'),
                        'hozzaadva'=>array('label'=>'Kérés beérkezése'),
                        'valaszolo'=>array('label'=>'Valaszoló'),
                        'megvalaszolva'=>array('label'=>'Megválaszolás dátuma'),
                        /*'infobox_kulcs'=>array('label'=>'Kulcs'),
                        'infobox_letrehozo'=>array('label'=>'Létrehozó'),
                        'infobox_letrehozva'=>array('label'=>'Létrehozás ideje'),
                        'infobox_modosito'=>array('label'=>'Módosító'),
                        'infobox_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        'infobox_aktiv'=>array('label'=>'Közzétéve', 'width'=>8)*/
                );
                $this->_params['TxtSort']->_value='elso__ASC';
                $this->addItem('FilterStatus')->_select_value=array(""=>"--Válasszon--", "1"=>"Megválaszolt", "2"=>"Még meg nem válaszolt");
        }

        public function __loadListCount() {
        $this->__createWhere();
        $query = "SELECT COUNT(DISTINCT(`{$this->_tableName}`.{$this->_tableName}_id)) AS cnt FROM `{$this->_tableName}` {$this->_join}";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array("cnt");
    }
}