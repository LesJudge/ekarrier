<?php
class Ceg_SiteList_Model extends Admin_List_Model
{
        
        public $_tableName='ceg';
        //public $_fields='ceg_id,ceg_nev,ceg_link';
        public $_fields='ceg.ceg_id,nev,link, tartalom';
        //public $_join='INNER JOIN user u ON u.user_id=ceg_id
          //                      INNER JOIN user_attr_cim uac ON uac.user_attr_user_id=ceg.user_id AND user_attr_cim_tipus=3';
        public $_join='INNER JOIN ceg_szekhely ON ceg.ceg_id=ceg_szekhely.ceg_id
                       INNER JOIN ceg_adatok ON ceg_adatok.ceg_id=ceg.ceg_id
                       LEFT JOIN szektor ON szektor.szektor_id=ceg_adatok.szektor_id
                       LEFT JOIN cim_varos ON cim_varos.cim_varos_id=ceg_szekhely.cim_varos_id
                       LEFT JOIN ceg_attr_munkakor ON ceg_attr_munkakor.ceg_id=ceg.ceg_id'
                ;
        
        public function __construct()
        {
                parent::__construct();
        }
        
        public function __addForm()
        {
                parent::__addForm();
                $this->addItem('FilterName');
                $this->addItem('FilterCity');
                
                $sectors=$this->getSelectValues('szektor', 'szektor_nev');
                $sectors[-1]="Válasszon";
                ksort($sectors);
                $this->addItem('FilterSector')->_select_value=$sectors;
                
                $default=array('-1' => "Válasszon");
                $munkaKorok=$this->getSelectValues('munkakor', 'munkakor_nev',"","ORDER BY munkakor_nev ASC",true,$default);
                //array_unshift($munkaKorok, "Válasszon");
                //print_r($munkaKorok);
                $this->addItem('FilterMunkakor')->_select_value=$munkaKorok;
                
        }
        
}