<?php
class Szakertovelemenye_Edit_Model extends Admin_Edit_Model
{

        public $_tableName='szakertovelemenye';
        public $_bindArray=array(
                'velemeny'=>'TxtVelemeny',
        );
        
        

        public function __addForm()
        {
                parent::__addForm();
                // Név
                $this->addItem('TxtVelemeny')->_verify['string']=true;
                
        }

        public function __editData()
        {
            /*
                parent::__editData();
                $query="SELECT infobox_javitas_szama, 
                                            DATE_FORMAT(infobox_create_date,'%Y-%m-%d %H:%i') AS infobox_create_date, 
                                            DATE_FORMAT(infobox_modositas_datum,'%Y-%m-%d %H:%i') AS infobox_modositas_datum, 
                                            u1.user_fnev AS infobox_letrehozo, 
                                            u2.user_fnev AS infobox_modosito
                               FROM {$this->_tableName}
                               LEFT JOIN user AS u1 ON infobox_letrehozo=u1.user_id
                               LEFT JOIN user AS u2 ON infobox_modosito=u2.user_id
                               WHERE infobox_id='{$this->modifyID}' AND 
                                            infobox.nyelv_id='{$this->nyelvID}'
                               LIMIT 1";
                $data=$this->_DB->prepare($query)->query_select()->query_fetch_array();
                return $data;
             */
        }

        public function __update()
        {
                parent::__update(',valasz_date=now()
                                              ,megvalaszolva=1
                                              ,valaszolo_id='.UserLoginOut_Controller::$_id
                );
        }

        public function __insert()
        {
                //parent::__insert(',infobox_letrehozo='.UserLoginOut_Controller::$_id);
        }


        public function getCompRajz()
        {
            try
            {
                $query = "SELECT kr.kompetenciarajz_id AS ID, kr.kompetenciarajz_nev AS nev
                          FROM szakertovelemenye szv
                          INNER JOIN kompetenciarajz kr ON kr.kompetenciarajz_id = szv.kompetenciarajz_id
                          WHERE szv.szakertovelemenye_id = ".(int)$this->modifyID." LIMIT 1";

                return $this->_DB->prepare($query)->query_select()->query_fetch_array();
            }catch (Exception_MYSQL_Null_Rows $e)
            {
                return false;
            }   
        }
        
        public function getCompRajzCompetences($id)
        {
            try{
            
                $query = "SELECT k.kompetencia_nev AS nev, krk.valasz AS valasz
                          FROM kompetenciarajz_kompetencia krk
                          INNER JOIN kompetencia k ON k.kompetencia_id = krk.kompetencia_id
                          WHERE krk.kompetenciarajz_id = ".(int)$id;

                return $this->_DB->prepare($query)->query_select()->query_result_array();
            }catch (Exception_MYSQL_Null_Rows $e)
            {
                return array();
            } 
            
        }
        

}