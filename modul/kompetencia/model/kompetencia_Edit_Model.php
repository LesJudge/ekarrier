<?php
class Kompetencia_Edit_Model extends MkAdminEditBaseModel
{

        public $_tableName='kompetencia';
        public $_type='';
        public $_bindArray=array(
                'kompetencia_nev'=>'TxtNev',
                'kompetencia_link'=>'TxtLink',
                'kompetencia_leiras'=>'TxtLeiras',
                'kompetencia_meta_kulcsszo'=>'TxtKulcsszo',
                'kompetencia_tartalom'=>'TxtTartalom',
                //'kompetencia_szinkod'=>'TxtSzinkod',
                'kompetencia_aktiv'=>'ChkAktiv',
                'checked'=>'ChkChecked',
                'tipus' =>'TxtTipus'
            );

        public function __addForm()
        {
                parent::__addForm();
                
                
                // Név
                $this->addItem('TxtNev')->_verify['string']=true;
               
               
                    
                // Link
                $link=$this->addItem('TxtLink');
                $link->_verify['string']=true;
                $link->_verify['unique']=array(
                        'table'=>'kompetencia',
                        'field'=>'kompetencia_link',
                        'modify'=>$this->modifyID,
                        'DB'=>$this->_DB
                );
                // Leírás
                $this->addItem('TxtLeiras')->_verify['string']=true;
                // Kulcsszó
                $this->addItem('TxtKulcsszo')->_verify['required']=true;
                // Tartalom
                $this->addItem('TxtTartalom')->_verify['string']=true;
                //Színkód
                //$this->addItem('TxtSzinkod');
                // Kapcsolódó munkakörök
                /*
                $this->addItem('SelKapcsolodo')->_select_value=$this->getSelectValues(
                        'munkakor',
                        'munkakor_nev',
                        ' AND munkakor_aktiv=1 AND munkakor_torolt=0',
                        ' ORDER BY munkakor_nev ASC',
                        true
                );
                */
                $this->addItem('SelKapcsolodo')->_select_value=$this->getSelectValues(
                        'szektor',
                        'szektor_nev',
                        ' AND szektor_aktiv=1 AND szektor_torolt=0',
                        ' ORDER BY szektor_nev ASC',
                        true
                );
               
                
                
               $this->addItem("ChkChecked")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
               $this->addItem('TxtTipus');
               
              
        }

        public function deleteMegtekintes()
        {
                $query="UPDATE {$this->_tableName} SET kompetencia_megtekintve=0
                              WHERE kompetencia_id='{$this->modifyID}' AND 
                                           nyelv_id='{$this->nyelvID}'
                              LIMIT 1";
                $this->_DB->prepare($query)->query_update();
        }

        public function removeAccentsFromLink()
        {
            if($this->_type!='ugyfel'){
                $this->_params['TxtLink']->_value=Create::remove_accents($this->_params['TxtLink']->_value);
            }
        }

        public function removeDelimitterFromKulcsszo()
        {
                while(strpos($this->_params['TxtKulcsszo']->_value, ',,')!==false)
                {
                        $this->_params['TxtKulcsszo']->_value=str_replace(',,', ',', $this->_params['TxtKulcsszo']->_value);
                }
        }

        public function __newData()
        {
                parent::__newData();
        }

        public function __editData()
        {
                parent::__editData();
                
               
                $query="SELECT kompetencia_megtekintve,
                                            kompetencia_javitas_szama, 
                                            DATE_FORMAT(kompetencia_create_date,'%Y-%m-%d %H:%i') AS kompetencia_create_date, 
                                            DATE_FORMAT(kompetencia_modositas_datum,'%Y-%m-%d %H:%i') AS kompetencia_modositas_datum, 
                                            u1.user_fnev AS kompetencia_letrehozo, 
                                            u2.user_fnev AS kompetencia_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON kompetencia_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON kompetencia_modosito=u2.user_id
                               WHERE kompetencia_id='{$this->modifyID}' AND 
                                            kompetencia.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __formValues()
        {
                parent::__formValues();
                
                //$this->_params['SelKapcsolodo']->_value=$this->getSelectedMkValues('munkakor_id','kompetencia_id',$this->modifyID);
                
                    $this->_params['SelKapcsolodo']->_value=$this->getSelectedMkValues('szektor_id','kompetencia_id',$this->modifyID);
                
        }

        public function __update()
        {
            
            if($this->_params['TxtTipus']->_value == 'sajat'){
                $this->_params['ChkChecked']->_value = 1;
                
            
               $this->deleteSectorsByCompetenceId($this->modifyID);

                    parent::__update(',kompetencia_modositas_datum=now()
                                                  ,kompetencia_javitas_szama=kompetencia_javitas_szama+1
                                                  ,kompetencia_modosito='.UserLoginOut_Controller::$_id
                    );
                    $sectors = $this->_params['SelKapcsolodo']->_value;
                    if (is_array($sectors) && !empty($sectors)) {
                        foreach ($sectors as $sector) {
                            $this->saveSector($sector, $this->modifyID);
                        }
                    }
                
            }elseif($this->_params['TxtTipus']->_value == 'ugyfel'){
                $this->_params['TxtLink']->_value = "sajat";
                $this->_params['TxtLeiras']->_value = "sajat";
                $this->_params['TxtKulcsszo']->_value = ",sajat,";
                $this->_params['TxtTartalom']->_value = "sajat";
                //$this->_params['TxtSzinkod']->_value = "";
            
                    parent::__update(',kompetencia_modositas_datum=now()
                                                  ,kompetencia_javitas_szama=kompetencia_javitas_szama+1
                                                  ,kompetencia_modosito='.UserLoginOut_Controller::$_id
                    );
           }
                
               
           
        }

        public function __insert()
        {
            //unset($this->_bindArray['checked']);
            //unset($this->_bindArray['tipus']);
            $this->_params['TxtTipus']->_value = 'sajat';
            
                parent::__insert(',kompetencia_letrehozo='.UserLoginOut_Controller::$_id);
                $sectors = $this->_params['SelKapcsolodo']->_value;
                if (is_array($sectors) && !empty($sectors)) {
                    foreach ($sectors as $sector) {
                        $this->saveSector($sector, $this->insertID);
                    }
                }
                
        }

        protected function deleteSectorsByCompetenceId($compId)
        {
            $this->_DB->prepare("DELETE FROM szektor_kompetencia WHERE kompetencia_id = " . (int)$compId)->query_execute();
        }
        
        protected function saveSector($sectorId, $compId)
        {
            $this->_DB->prepare("INSERT INTO szektor_kompetencia (szektor_id, kompetencia_id) VALUES (" . (int)$sectorId . ", " . (int)$compId . ")")->query_insert();
        }
        
        /**
         * Elmenti a kompetenciához tartozó munkaköröket.
         * @param string $field => A mező neve. (kompetencia_id legyen!)
         * @param string $id => A kompetencia azonosítója.
         * @param array $values => Az értékeket tartalmazó tömb.
         * @deprecated
         */
        protected function saveMkValues($field, $id, $values)
        {
                $this->deleteMkValues($field,$id);
                if(is_array($values))
                {
                        foreach($values as $value)
                        {
                                $this->saveMkValue($value,$id);
                        }
                }
        }


        public function kompetenciaAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A kompetencia nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

        public function getType(){
            try{
                $query = "SELECT tipus FROM kompetencia WHERE kompetencia_id = ".$this->modifyID." LIMIT 1";
                $result = $this->_DB->prepare($query)->query_select()->query_fetch_array();
                
                if($result['tipus']=='ugyfel'){
                    $this->_type = 'ugyfel';
                }else{
                    $this->_type = '';
                }
                
                return $result['tipus'];
            }catch(Exception_MYSQL_Null_Rows $e){
                
            }
        }
}