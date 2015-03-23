<?php
class Beallitas_PozicioEdit_Model extends Admin_Edit_Model
{

        public $_tableName='pozicio';
        public $_bindArray=array(
                'pozicio_nev'=>'TxtNev',
                'pozicio_leiras'=>'TxtLeiras',
                'pozicio_aktiv'=>'ChkAktiv',
        );

        public function __addForm()
        {
                parent::__addForm();
                // Név
                $this->addItem('TxtNev')->_verify['string']=true;
                $this->addItem('TxtLeiras')->_verify['string']=true;
                
                $this->addItem('SelKomps')->_select_value=$this->getSelectValues(
                        'kompetencia',
                        'kompetencia_nev',
                        ' AND kompetencia_aktiv=1 AND kompetencia_torolt=0 AND tipus != "ugyfel" ',
                        ' ORDER BY kompetencia_nev ASC',
                        true
                );
        }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT javitas_szama, 
                                            DATE_FORMAT(letrehozas_timestamp,'%Y-%m-%d %H:%i') AS pozicio_create_date, 
                                            DATE_FORMAT(modositas_timestamp,'%Y-%m-%d %H:%i') AS pozicio_modositas_datum, 
                                            u1.user_fnev AS pozicio_letrehozo, 
                                            u2.user_fnev AS pozicio_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON letrehozo_id=u1.user_id
                               LEFT JOIN user AS u2 ON modosito_id=u2.user_id
                               WHERE pozicio_id='{$this->modifyID}' AND 
                                            pozicio.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __formValues()
        {
                parent::__formValues();
                
                $this->_params['SelKomps']->_value=$this->getSelectedKompValues('kompetencia_id','pozicio_id',$this->modifyID);
        }
        
        public function getSelectedKompValues($selectField,$whereField,$id)
        {
                try
                {
                        $query="SELECT {$selectField} FROM pozicio_attr_kompetencia WHERE {$whereField}=".(int)$id;
                        
                        $dataObj=$this->_DB->prepare($query)->query_select();
                        $returnData=array();
                        while($data=$dataObj->query_fetch_array())
                        {
                                $sid=$data[$selectField];
                                $returnData[$sid]=$sid;
                        }
                        return $returnData;
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return array();
                }    
        }
        
        public function __update()
        {
            $this->deleteCompsByPositionId($this->modifyID);
                parent::__update(',modositas_timestamp=now(),
                                    javitas_szama = javitas_szama+1
                                              ,modosito_id='.UserLoginOut_Controller::$_id
                );
                
                $comps = $this->_params['SelKomps']->_value;
                if (is_array($comps) && !empty($comps)) {
                    foreach ($comps as $comp) {
                        $this->saveComp($comp, $this->modifyID);
                    }
                }
        }
        
        protected function deleteCompsByPositionId($posId)
        {
            $this->_DB->prepare("DELETE FROM pozicio_attr_kompetencia WHERE pozicio_id = " . (int)$posId)->query_execute();
        }
        
        protected function saveComp($compId, $posId)
        {
            $this->_DB->prepare("INSERT INTO pozicio_attr_kompetencia (kompetencia_id, pozicio_id) VALUES (" . (int)$compId . ", " . (int)$posId . ")")->query_insert();
        }

        public function __insert()
        {
                parent::__insert(',letrehozo_id='.UserLoginOut_Controller::$_id);
                
                $comps = $this->_params['SelKomps']->_value;
                if (is_array($comps) && !empty($comps)) {
                    foreach ($comps as $comp) {
                        $this->saveComp($comp, $this->insertID);
                    }
                }
        }

        public function pozicioAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A pozíció nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

}