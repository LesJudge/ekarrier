<?php
class Kompetencia_SiteRajzEdit_Model extends Page_Edit_Model
{
        protected $userId;
        protected $_clientID;
        
        public function __construct()
        {
                $this->addDB('MYSQL_DB');
        }
        
        public function getUserId(){
            return $this->userId;
        }
        
        public function setUserId($userId)
        {
            $this->userId = (int)$userId;
        }
        
        public function setClientId($clientId)
        {
            $this->_clientID = (int)$clientId;
        }
        
        public function __addForm()
        {
            parent::__addForm();
            
        }
        
        
        
        public function getCompRajzById($id)
        {
           
            $query = "
                    SELECT kompetenciarajz_id, kompetenciarajz_nev
                    FROM kompetenciarajz
                    WHERE kompetenciarajz_id = ".(int)$id."
                    AND ugyfel_id = ".(int)$this->_clientID."
                    LIMIT 1    
                    ";
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
            
        }
        
        public function getAllCompRajz()
        {
            try
            {
            $query = "
                    SELECT kompetenciarajz_id AS ID, kompetenciarajz_nev AS nev
                    FROM kompetenciarajz
                    WHERE ugyfel_id = ".(int)$this->_clientID    
                    ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
            }
            catch(Exception_MYSQL_Null_Rows $e)
            {
                return array();
            }
            catch(Exception_MYSQL $e){
            }
        }
        
        
        public function findCompetencesByClientId($id,$lId)
        {
            try
            {
                $query = "SELECT ugyfel_attr_kompetencia_ugyfel_id, kompetencia.kompetencia_nev, ugyfel_attr_kompetencia_tesztbol, kompetencia_id, kompetencia_szinkod, kompetencia_leiras
                               FROM ugyfel_attr_kompetencia
                               INNER JOIN kompetencia
                               ON kompetencia.kompetencia_id = ugyfel_attr_kompetencia.ugyfel_attr_kompetencia_kompetencia_id
                               WHERE ugyfel_attr_kompetencia_ugyfel_id='".mysql_real_escape_string($id)."' AND kompetencia.kompetencia_aktiv = 1 AND kompetencia.kompetencia_torolt = 0 
                               AND
                                            nyelv_id=".(int)$lId;
                return $this->_DB->prepare($query)->query_select()->query_result_array();
            }
            catch(Exception_MYSQL_Null_Rows $e)
            {
            
            }
            catch(Exception_MYSQL $e)
            {
            
            }
        }
        
        public function findCompetencesByCompRajzId($id,$lId)
        {
            try{
                $query="SELECT k.kompetencia_id AS kompetencia_id,
                                k.kompetencia_nev AS kompetencia_nev,
                                k.kompetencia_szinkod AS kompetencia_szinkod,
                                k.kompetencia_leiras AS kompetencia_leiras,
                                kk.valasz AS valasz
                               FROM kompetenciarajz_kompetencia kk
                               INNER JOIN kompetencia k ON k.kompetencia_id = kk.kompetencia_id 
                               WHERE kk.kompetenciarajz_id=".(int)$id."
                               AND k.kompetencia_torolt=0
                               AND k.kompetencia_aktiv=1
                                            ";
                return $this->_DB->prepare($query)->query_select()->query_result_array();
            }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
        }
        
        
        /*
        public function getAllCompetences($lId)
        {
            try{    
            $query="SELECT kompetencia_nev, kompetencia_id, kompetencia_szinkod
                               FROM kompetencia
                               WHERE kompetencia_aktiv=1
                               AND kompetencia_torolt=0
                               AND nyelv_id=".(int)$lId;
                return $this->_DB->prepare($query)->query_select()->query_result_array();
                }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
        }
       */
       public function saveCompRajz($compRajzNev, $kompetenciak, $valaszok)
       {
           $compRajzID = "";

           $clientId = $this->_clientID;
           $query = " INSERT INTO kompetenciarajz
                   (kompetenciarajz_nev, ugyfel_id)
                   VALUES ('".mysql_real_escape_string($compRajzNev)."',".(int)$clientId.")
                   ";
           
           $compRajzID = $this->_DB->prepare($query)->query_insert();

           foreach ($kompetenciak as $key => $value) {
               $kompID = $kompetenciak[$key];
               $valasz = $valaszok[$key];
               $query = " INSERT INTO kompetenciarajz_kompetencia
                   (kompetenciarajz_id, kompetencia_id,valasz)
                   VALUES (".(int)$compRajzID.",".(int)$kompID.",'".  mysql_real_escape_string($valasz)."')
                   ";
               
               $this->_DB->prepare($query)->query_insert();
           }     
       }
       
       public function updateCompRajz($compRajzNev, $kompetenciak, $valaszok, $compRajzID){
           
           $query = "UPDATE kompetenciarajz
                     SET kompetenciarajz_nev = '".mysql_real_escape_string($compRajzNev)."'
                     WHERE kompetenciarajz_id = ".(int)$compRajzID
                   ;
           
           $this->_DB->prepare($query)->query_execute();
           
           $query = "DELETE FROM kompetenciarajz_kompetencia WHERE kompetenciarajz_id = ".$compRajzID;
           
           $this->_DB->prepare($query)->query_execute();
           
           foreach ($kompetenciak as $key => $value) {
               $kompID = $kompetenciak[$key];
               $valasz = $valaszok[$key];
               $query = " INSERT INTO kompetenciarajz_kompetencia
                   (kompetenciarajz_id, kompetencia_id,valasz)
                   VALUES (".(int)$compRajzID.",".(int)$kompID.",'".  mysql_real_escape_string($valasz)."')
                   ";
               
               $this->_DB->prepare($query)->query_insert();
           }

       }
            
              
       public function checkIfCompRajzExistsByName($name)
       {
           try
           {
            $query = "SELECT kompetenciarajz_id FROM kompetenciarajz WHERE kompetenciarajz_nev = '".  mysql_real_escape_string($name)."' AND ugyfel_id = ".(int)$this->_clientID;
            $this->_DB->prepare($query)->query_select();
            return true;
           } catch (Exception_MYSQL_Null_Rows $e) {
               return false;
           }
       }
       
       public function deleteCompRajz($id)
       { 
                $query = "DELETE FROM kompetenciarajz WHERE kompetenciarajz_id = ".(int)$id;
                $this->_DB->prepare($query)->query_execute();
                
                $query = "DELETE FROM kompetenciarajz_kompetencia WHERE kompetenciarajz_id = ".(int)$id;
                $this->_DB->prepare($query)->query_execute();
   
       }
       
       public function requestExpertOpinion($krID)
       {
           
           $clientId = $this->_clientID;
           
               $query = " INSERT INTO szakertovelemenye
                   (kompetenciarajz_id, megvalaszolva, ugyfel_id, hozzaadas_date)
                   VALUES (".(int)$krID.",0,".(int)$clientId.", NOW())
                   ";
                $this->_DB->prepare($query)->query_insert();
           
       }
       
       public function checkIfRequestExistsWithNoAnswer($krID)
       {
           try
           {
            $query = "SELECT szakertovelemenye_id FROM szakertovelemenye WHERE kompetenciarajz_id = ".(int)$krID." AND megvalaszolva = 0";
            $this->_DB->prepare($query)->query_select();
            return true;
           } catch (Exception_MYSQL_Null_Rows $e) {
               return false;
           }
       }
       
       public function getOpinionsByCompRajzID($krID)
       {
           try
           {
                $query = "SELECT velemeny, valasz_date, CONCAT(u1.user_vnev,' ',u1.user_knev) AS valaszolo, valasz_date
                             FROM szakertovelemenye
                             LEFT JOIN user u1 ON u1.user_id = szakertovelemenye.valaszolo_id
                             WHERE kompetenciarajz_id = ".(int)$krID." AND megvalaszolva = 1 AND szakertovelemenye_torolt=0";

                return $this->_DB->prepare($query)->query_select()->query_result_array();
           } catch (Exception_MYSQL_Null_Rows $e) {
               return array();
           }
           catch(Exception_MYSQL $e)
           {
           } 
           
       }
       
       
       
       
       public function validateComprajzNev($nev)
       {
           if(empty($nev) || strlen($nev) < 5)
           {
             return false;  
           }else{
             return true;
           }
       }
}