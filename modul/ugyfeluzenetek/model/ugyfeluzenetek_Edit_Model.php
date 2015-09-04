<?php
class Ugyfeluzenetek_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='ugyfel_attr_uzenetek';
        public $_bindArray=array(
                'uzenet'=>'TxtTartalom',
                'uzenet_elolvasva'=>'ChkSeen',
                'ugyfel_attr_uzenetek_aktiv'=>'ChkAktiv',
                'ugyfel_id' => 'SelUgyfel',
                'ugyfel_latta' => 'ChkSeenByClient'
        );

        public function __addForm()
        {
                parent::__addForm();
                
                // Tartalom
                $this->addItem('TxtTartalom')->_verify['string']=true;
                
                $defaultArray=array(""=>"Válasszon ügyfelet");
                $ugyfelSel = $this->addItem('SelUgyfel');
                $ugyfelSel->_select_value = $this->getSelectValues(
                        'ugyfel',
                        'CONCAT(vezeteknev,\' \',keresztnev)',
                        ' AND ugyfel_aktiv=1 AND ugyfel_torolt=0',
                        ' ORDER BY vezeteknev ASC',
                        false,
                        $defaultArray
                );
                $ugyfelSel->_verify['select']=true;
                
                $this->addItem("ChkSeen")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
                $this->addItem("ChkSeenByClient")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];

        }

        

        public function __newData()
        {
                parent::__newData();
                $this->_params['SelUgyfel']->_value = $_GET['answerTo'];
                $this->_params['ChkSeenByClient']->_value = 0;
                $this->_params['ChkSeen']->_value = 1;
        }

        public function __editData()
        {
                parent::__editData();
                $this->_params['ChkSeen']->_value = 1;
                
        }

        public function __formValues()
        {
                parent::__formValues();

        }

        public function __update()
        {
         
            parent::__update(',modositas_datum=now(),modosito='.UserLoginOut_Controller::$_id
            );
            
        }

        public function __insert()
        {
                parent::__insert(', szerzo='.UserLoginOut_Controller::$_id);
                
        }

        
/*
        
        public function getAllMessages()
        {
            
            $query = "SELECT k.kompetencia_nev AS nev, k.kompetencia_tartalom AS tartalom
                      FROM kompetencia_hozzaszolas kh
                      INNER JOIN kompetencia k ON k.kompetencia_id = kh.kompetencia_id
                      WHERE kh.kompetencia_hozzaszolas_id = ".(int)$this->modifyID." LIMIT 1";
            
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
            
        }
 * 
 */
}