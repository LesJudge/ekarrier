<?php
class Beallitas_Szektor_Comment_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='szektor_hozzaszolas';
        public $_bindArray=array(
                'hozzaszolas'=>'TxtTartalom',
                'szektor_hozzaszolas_aktiv'=>'ChkAktiv',
                'checked'=>'ChkChecked'
        );

        public function __addForm()
        {
                parent::__addForm();
                
                $this->addItem('TxtTartalom')->_verify['string']=true;
                $this->addItem("ChkChecked")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];

        }

        

        public function __newData()
        {
                parent::__newData();
        }

        public function __editData()
        {
                parent::__editData();
                
        }

        public function __formValues()
        {
                parent::__formValues();

        }

        public function __update()
        {
            
                parent::__update(',modositas_datum=now()
                                  ,modosito='.UserLoginOut_Controller::$_id
                );
            
        }

        public function __insert()
        {
        //        parent::__insert(',kompetencia_letrehozo='.UserLoginOut_Controller::$_id);
                
        }

        
        public function getSecDescription()
        {
            
            $query = "SELECT sz.szektor_nev AS nev, sz.szektor_leiras AS tartalom
                      FROM szektor_hozzaszolas szh
                      INNER JOIN szektor sz ON sz.szektor_id = szh.szektor_id
                      WHERE szh.szektor_hozzaszolas_id = ".(int)$this->modifyID." LIMIT 1";
            
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
            
        }
}