<?php
class Tevekenysegikor_Comment_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='tevekenysegikor_hozzaszolas';
        public $_bindArray=array(
                'hozzaszolas'=>'TxtTartalom',
                'tevekenysegikor_hozzaszolas_aktiv'=>'ChkAktiv'
        );

        public function __addForm()
        {
                parent::__addForm();
                
                // Tartalom
                $this->addItem('TxtTartalom')->_verify['string']=true;

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

        

        
        public function getTevkorDescription()
        {
            
            $query = "SELECT mk.kategoria_cim AS nev, mk.kategoria_leiras AS tartalom
                      FROM tevekenysegikor_hozzaszolas th
                      INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = th.tevekenysegikor_id
                      WHERE th.tevekenysegikor_hozzaszolas_id = ".(int)$this->modifyID." LIMIT 1";
            
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
            
        }
}