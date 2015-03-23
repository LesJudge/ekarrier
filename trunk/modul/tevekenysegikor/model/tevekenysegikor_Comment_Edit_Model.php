<?php
class Tevekenysegikor_Comment_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='tevekenysegikor_hozzaszolas';
        public $_bindArray=array(
                'hozzaszolas'=>'TxtTartalom',
                'tevekenysegikor_hozzaszolas_aktiv'=>'ChkAktiv',
                'checked'=>'ChkChecked',
                'type'=>'TxtType',
                'tevekenysegikor_id'=>'TxtTevkorID'
        );

        public function __addForm()
        {
                parent::__addForm();
                
                $this->addItem('TxtTartalom')->_verify['string']=true;
                $this->addItem('TxtType')->_verify['string']=true;
                $this->addItem('TxtTevkorID')->_verify['string']=true;
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

        
        public function getTevkorDescription()
        {
            
            $query = "SELECT mk.kategoria_cim AS nev, mk.kategoria_leiras AS tartalom
                      FROM tevekenysegikor_hozzaszolas th
                      INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = th.tevekenysegikor_id
                      WHERE th.tevekenysegikor_hozzaszolas_id = ".(int)$this->modifyID." LIMIT 1";
            
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
            
        }
        
        public function getRelatedInfo($type,$tkID){
            switch ($type) {
                case 'desc':
                    return 'desc';
                    break;
                
                case 'exp':
                    return $this->getExpectations($tkID);
                    break;
                
                case 'tasks':
                    return $this->getTasks($tkID);
                    break;
                
                case 'comp':
                    return $this->getCompetences($tkID);
                    break;

                default:
                    break;
            }
        }
        
        public function getExpectations($tkID){
            try {
                $query = "SELECT 
                            aae.elvaras AS text
                          FROM allashirdetes_attr_elvaras aae
                          INNER JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = aae.allashirdetes_id
                          INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = aam.munkakor_id
                          INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id
                          WHERE mk.munkakor_kategoria_id = ".(int)$tkID."
                          GROUP BY aae.elvaras";
                return $this->_DB->prepare($query)->query_select()->query_result_array();
            } catch (Exception_MYSQL_Null_Rows $emnr) {
                return array();
            } catch (Exception_MYSQL $e) {
                return array('0'=>array('text'=>'Hiba történt'));
            }
        }
        
        public function getTasks($tkID){
            try {
                $query = "SELECT 
                        aaf.feladat AS text
                      FROM allashirdetes_attr_feladat aaf
                      INNER JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = aaf.allashirdetes_id
                      INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = aam.munkakor_id
                      INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id
                      WHERE mk.munkakor_kategoria_id = ".(int)$tkID."
                      GROUP BY aaf.feladat";
                return $this->_DB->prepare($query)->query_select()->query_result_array();
            } catch (Exception_MYSQL_Null_Rows $emnr) {
                return array();
            } catch (Exception_MYSQL $e) {
                return array('0'=>array('text'=>'Hiba történt'));
            }
        }
        
        public function getCompetences($tkID){
            try {
                $query = "SELECT 
                        k.kompetencia_nev AS text
                      FROM allashirdetes_attr_kompetencia aak
                      INNER JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = aak.allashirdetes_id
                      INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = aam.munkakor_id
                      INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id
                      INNER JOIN kompetencia k ON k.kompetencia_id = aak.kompetencia_id
                      WHERE mk.munkakor_kategoria_id = ".(int)$tkID."
                      GROUP BY k.kompetencia_id";
                return $this->_DB->prepare($query)->query_select()->query_result_array();
            } catch (Exception_MYSQL_Null_Rows $emnr) {
                return array();
            } catch (Exception_MYSQL $e) {
                return array('0'=>array('text'=>'Hiba történt'));
            }
        }
        
        
        
}