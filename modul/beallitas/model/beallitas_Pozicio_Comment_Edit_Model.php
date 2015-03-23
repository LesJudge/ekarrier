<?php
class Beallitas_Pozicio_Comment_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='pozicio_hozzaszolas';
        public $_bindArray=array(
                'hozzaszolas'=>'TxtTartalom',
                'pozicio_hozzaszolas_aktiv'=>'ChkAktiv',
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

        

        
        public function getPosDescription()
        {
            
            $query = "SELECT p.pozicio_nev AS nev, p.pozicio_leiras AS tartalom
                      FROM pozicio_hozzaszolas ph
                      INNER JOIN pozicio p ON p.pozicio_id = ph.pozicio_id
                      WHERE ph.pozicio_hozzaszolas_id = ".(int)$this->modifyID." LIMIT 1";
            
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
            
        }
}