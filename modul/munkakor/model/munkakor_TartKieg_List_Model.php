<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Munkakor_TartKieg_List_Model extends Admin_List_Model
{

        public $_tableName;
        public $_fields;
        public $_join;

        public function __construct()
        {
                parent::__construct();
                $this->initTableName();
                $this->initFields();
                $this->initJoin();
        }
        
        public function __addForm()
        {
                parent::__addForm();
                $this->tableHeader=array(
                        'munkakor_nev'=>array('label'=>'Munkakör'),
                        $this->_tableName.'_feldolgozva'=>array('label'=>'Feldolgozva'),
                        $this->_tableName.'_letrehozo'=>array('label'=>'Létrehozó'),
                        $this->_tableName.'_letrehozva'=>array('label'=>'Létrehozás ideje'),
                        $this->_tableName.'_modosito'=>array('label'=>'Módosító'),
                        $this->_tableName.'_modositas_datum'=>array('label'=>'Módosítás ideje'),
                        $this->_tableName.'_aktiv'=>array('label'=>'Publikálva', 'width'=>8)
                );
                $this->_params['TxtSort']->_value='munkakor_nev__ASC';
                $this->addItem('FilterStatus')->_select_value=Rimo::$_config->CMSAllapot[Rimo::$_config->ADMIN_NYELV_ID];
                $this->addItem('FilterMunkakor')->_select_value=$this->getSelectValues(
                        'munkakor',
                        'munkakor_nev',
                        ' AND munkakor_aktiv=1 AND munkakor_torolt=0',
                        ' ORDER BY munkakor_nev ASC',
                        true,
                        array(''=>'--Válasszon munkakört!--')
                );
                $this->addItem('FilterPublikalva')->_select_value=Rimo::$_config->filterPublikalva;
                $this->addItem('FilterFeldolgozva')->_select_value=Rimo::$_config->filterFeldolgozva;
        }
        
        /**
         * Tábla név beállítása.
         */
        protected function initTableName()
        {
                $this->_tableName='munkakor_tartalom_kiegeszites';
        }
        
        /**
         * Mezők beállítása.
         */
        protected function initFields()
        {
                $this->_fields=$this->_tableName.'.'.$this->_tableName.'_id AS ID,
                                        munkakor_nev AS elso,
                                        IF('.$this->_tableName.'_feldolgozva=1,\'Igen\',\'Nem\') AS feldolgozva,
                                        IF('.$this->_tableName.'_letrehozo IS NULL,\'Ismeretlen\',CONCAT(u1.user_vnev,\' \',u1.user_knev)) AS letrehozo,
                                        IF('.$this->_tableName.'_modosito IS NULL,\'Nem lett módosítva\',CONCAT(u2.user_vnev,\' \',u2.user_knev)) AS modosito,
                                        '.$this->_tableName.'_create_date AS letrehozva,
                                        IF('.$this->_tableName.'_modositas_datum=0,\'Nem lett módosítva!\',munkakor_modositas_datum) AS modositva,
                                        '.$this->_tableName.'_aktiv AS Aktiv';
        }
        
        /**
         * Join összeállítása.
         */
        protected function initJoin()
        {
                $this->_join='INNER JOIN munkakor m ON m.munkakor_id='.$this->_tableName.'.munkakor_id
                                       LEFT JOIN user u1 ON u1.user_id='.$this->_tableName.'_letrehozo
                                       LEFT JOIN user u2 ON u2.user_id='.$this->_tableName.'_modosito';
        }

}