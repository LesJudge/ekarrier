<?php
class Munkakor_ElvKieg_List_Model extends Munkakor_TartKieg_List_Model
{
        
        public function __construct()
        {
                parent::__construct();
        }
        
        protected function initTableName()
        {
                $this->_tableName='munkakor_elvarasok_kiegeszites';
        }
}