<?php
class Munkakor_Edit_Model extends MkAdminEditBaseModel
{

        public $_tableName='munkakor';
        public $_bindArray=array(
                'munkakor_nev'=>'TxtNev',
                'munkakor_link'=>'TxtLink',
                'munkakor_leiras'=>'TxtLeiras',
                'munkakor_meta_kulcsszo'=>'TxtKulcsszo',
                'munkakor_tartalom'=>'TxtTartalom',
                'munkakor_elvarasok'=>'TxtElvarasok',
                'munkakor_aktiv'=>'ChkAktiv',
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
                        'table'=>'munkakor',
                        'field'=>'munkakor_link',
                        'modify'=>$this->modifyID,
                        'DB'=>$this->_DB
                );
                // Leírás
                $this->addItem('TxtLeiras')->_verify['string']=true;
                // Kulcsszó
                $this->addItem('TxtKulcsszo')->_verify['required']=true;
                // Tartalom
                $this->addItem('TxtTartalom')->_verify['string']=true;
                // Elvárások
                $this->addItem('TxtElvarasok');//->_verify['string']=true;
                // Kapcsolódó 
                $Kapcsolodo=$this->addItem('SelKapcsolodo');
                $Kapcsolodo->_select_value=$this->getSelectValues('munkakor','munkakor_nev');
//                ->_select_value=$this->getSelectValues(
//                        'munkakor',
//                        'munkakor_nev',
//                        ' AND munkakor_aktiv=1 AND munkakor_torolt=0',
//                        ' ORDER BY munkakor_nev ASC',
//                        true
//                );
                // Kategória
                $kategoria=$this->addItem('SelKategoria');
                $kategoria->_select_value=$this->getKategoriaSelectValues();
                $kategoria->_verify['multiSelect']=true;
        }

        public function deleteMegtekintes()
        {
                $query="UPDATE {$this->_tableName} SET munkakor_megtekintve=0
                              WHERE munkakor_id='{$this->modifyID}' AND 
                                           nyelv_id='{$this->nyelvID}'
                              LIMIT 1";
                $this->_DB->prepare($query)->query_update();
        }

        public function removeAccentsFromLink()
        {
                $this->_params['TxtLink']->_value=Create::remove_accents($this->_params['TxtLink']->_value);
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
               
                $this->_params['SelKategoria']->_value=0;
        }

        public function __editData()
        {
                parent::__editData();
                $query="SELECT munkakor_megtekintve,
                                            munkakor_javitas_szama, 
                                            DATE_FORMAT(munkakor_create_date,'%Y-%m-%d %H:%i') AS munkakor_create_date, 
                                            DATE_FORMAT(munkakor_modositas_datum,'%Y-%m-%d %H:%i') AS munkakor_modositas_datum, 
                                            u1.user_fnev AS munkakor_letrehozo, 
                                            u2.user_fnev AS munkakor_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON munkakor_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON munkakor_modosito=u2.user_id
                               WHERE munkakor_id='{$this->modifyID}' AND 
                                            munkakor.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
        }

        public function __formValues()
        {
                parent::__formValues();
                $this->_params['SelKategoria']->_value=$this->getSelectAktivValues('munkakor_attr_kategoria');
                $this->_params['SelKapcsolodo']->_value=$this->getSelectAktivValues('munkakor_attr_munkakor');
                
                //$this->_params['SelKapcsolodo']->_value=$this->getKapcsMkValues('munkakor_attr_munkakor_id','munkakor_id',$this->modifyID);
        }

        public function __update()
        {
                $activities=(isset($_POST['activity'])) ? $_POST['activity'] : false;
                if(is_array($activities))
                {
                        $this->deleteActivitiesByJobId($this->modifyID);
                        $this->saveActivities($this->modifyID,$activities,Rimo::$_config->ADMIN_NYELV_ID,UserLoginOut_Admin_Controller::$_id);                        
                }
                //$this->saveMkValues('munkakor_id',$this->modifyID,$this->_params['SelKapcsolodo']->_value);
                $this->saveSelect('munkakor_attr_kategoria',$this->_params['SelKategoria']->_value, $this->modifyID);
                $this->saveSelect('munkakor_attr_munkakor',$this->_params['SelKapcsolodo']->_value, $this->modifyID);
                parent::__update(',munkakor_modositas_datum=now()
                                              ,munkakor_javitas_szama=munkakor_javitas_szama+1
                                              ,munkakor_modosito='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                parent::__insert(',munkakor_letrehozo='.UserLoginOut_Controller::$_id);
                $this->saveSelect('munkakor_attr_kategoria',$this->_params['SelKategoria']->_value, $this->insertID);
                $this->saveSelect('munkakor_attr_munkakor',$this->_params['SelKapcsolodo']->_value, $this->insertID);
                //$this->saveMkValues('munkakor_id',$this->insertID,$this->_params['SelKapcsolodo']->_value);
                $activities=(isset($_POST['activity'])) ? $_POST['activity'] : false;
                if(is_array($activities))
                {
                        $this->saveActivities($this->insertID,$activities,Rimo::$_config->ADMIN_NYELV_ID,UserLoginOut_Admin_Controller::$_id);                        
                }
        }

        public function munkakorAllapot()
        {
                if($this->_params["ChkAktiv"]->_value!=1)
                {
                        return "<span class='ui-icon ui-icon-alert tip' title='<strong>Nem jelenik meg.</strong> A munkakor nem publikus!'></span>";
                }
                return "<span class='ui-icon ui-icon-circle-check tip' title='<strong>Megjelenik.</strong>'></span>";
        }

        /**
         * Elmenti a munkakörhöz kapcsolódó kompetenciákat.
         * @param string $field => A mező neve. (munkakor_id legyen!)
         * @param string $id => A munkakör azonosítója.
         * @param array $values => Az értékeket tartalmazó tömb.
         */
        protected function saveMkValues($field, $id, $values)
        {
                $this->deleteMkValues($field,$id);
                if(is_array($values))
                {
                        foreach($values as $value)
                        {
                                $this->saveMkValue($id,$value);
                        }
                }
        }
        
        public function getKategoriaSelectValues()
        {
                try
                {
                        $query="SELECT munkakor_kategoria_id AS id,   
                                                    kategoria_cim AS name,    
                                                    szint AS depth,
                                                    baloldal as bal,
                                                    jobboldal AS jobb
                                       FROM  munkakor_kategoria    
                                       WHERE nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID."   
                                       GROUP BY munkakor_kategoria_id   
                                       ORDER BY baloldal";
                        $obj=$this->_DB->prepare($query)->query_select();
                        while($adat=$obj->query_fetch_array())
                        {
                                $added='';
                                for($i=0; $i<$adat['depth']; $i++)
                                {
                                        $added .= '--';
                                }
                                if($adat['depth']==0)
                                {
                                        $list[$adat['id']]='<'.$adat['name'].'>';
                                }
                                else
                                {
                                        $list[$adat['id']]=$added.$adat['name'];
                                }
                        }
                        return $list;
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return array();
                }
                catch(Exception_MYSQL $e)
                {
                        return array(0=>'HIBA');
                }
        }

}