<?php
class Kompetencia_SiteList_Model extends Page_List_Model
{
        public $_tableName='kompetencia';
        public $_fields='kompetencia_id,kompetencia_nev,kompetencia_link';
        public $listWhere=array(0=>'kompetencia_aktiv=1',
                                1=>'tipus = "sajat"',
            );
        
}