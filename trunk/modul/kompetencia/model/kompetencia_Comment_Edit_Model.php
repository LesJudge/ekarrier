<?php
class Kompetencia_Comment_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='kompetencia_hozzaszolas';
        public $_bindArray=array(
                'hozzaszolas'=>'TxtTartalom',
                'kompetencia_hozzaszolas_aktiv'=>'ChkAktiv'
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

        

        
        public function getCompDescription()
        {
            
            $query = "SELECT k.kompetencia_nev AS nev, k.kompetencia_tartalom AS tartalom
                      FROM kompetencia_hozzaszolas kh
                      INNER JOIN kompetencia k ON k.kompetencia_id = kh.kompetencia_id
                      WHERE kh.kompetencia_hozzaszolas_id = ".(int)$this->modifyID." LIMIT 1";
            
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
            
        }
}