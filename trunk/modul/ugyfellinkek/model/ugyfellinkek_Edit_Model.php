<?php
class Ugyfellinkek_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='ugyfel_attr_linkek';
        public $_bindArray=array(
                'link_nev'=>'TxtNev',
                'link_url'=>'TxtUrl',
                'category'=>'SelKat',
                'tipus'=>'TxtTipus',
                'checked'=>'ChkChecked',
                'ugyfel_attr_linkek_aktiv'=>'ChkAktiv',
        );

        public function __addForm()
        {
                parent::__addForm();
                // Név
                
                
                $this->addItem('TxtNev')->_verify['string']=true;
                $this->addItem('TxtUrl')->_verify['string']=true;
                $selKat = $this->addItem('SelKat');
                $selKat->_verify['select']=true;
                $selKat->_select_value = array(''=>'--Válasszon--','kompetencia'=>'Kompetencia','szektor'=>'Szektor', 'pozicio'=>'Pozíció'); 
                
                $this->addItem('TxtTipus');
                $this->addItem("ChkChecked")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];

        }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT 
                                            DATE_FORMAT(letrehozas_timestamp,'%Y-%m-%d %H:%i') AS pozicio_create_date, 
                                            DATE_FORMAT(modositas_timestamp,'%Y-%m-%d %H:%i') AS pozicio_modositas_datum, 
                                            u1.user_fnev AS letrehozo_id, 
                                            u2.user_fnev AS modosito_id
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON letrehozo_id=u1.user_id
                               LEFT JOIN user AS u2 ON modosito_id=u2.user_id
                               WHERE ugyfel_attr_linkek_id='{$this->modifyID}' AND 
                                            ugyfel_attr_linkek.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __formValues()
        {
                parent::__formValues();
                
        }
        
                
        public function __update()
        {
            
            
            if($this->_params['TxtTipus']->_value == 'sajat'){
                
                $this->_params['ChkChecked']->_value = 1;
            }
            
                parent::__update(',modositas_timestamp=now(),
                                   modosito_id='.UserLoginOut_Controller::$_id
                );
                
        }

        public function __insert()
        {
            
               $this->_params['TxtTipus']->_value = 'sajat';     
                parent::__insert(',letrehozo_id='.UserLoginOut_Controller::$_id.', letrehozas_timestamp = now()');
                
               
        }

        public function linkAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A pozíció nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }
        
        

}