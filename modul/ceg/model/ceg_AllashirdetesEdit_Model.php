<?php
/**
 * Site álláshirdetés edit model
 */
class Ceg_AllashirdetesEdit_Model extends Page_Edit_Model
{
        
        public $_tableName='allashirdetes';
        public $_bindArray=array(
                'allashirdetes_nev'=>'TxtNev'
        );
        
}