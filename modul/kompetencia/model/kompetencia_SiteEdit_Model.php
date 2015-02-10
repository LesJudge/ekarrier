<?php
class Kompetencia_SiteEdit_Model extends Page_Edit_Model
{
        protected $userId;
        
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
        
        public function __addForm()
        {
            parent::__addForm();
            $this->addItem('BtnDeleteComp');
            $this->addItem('BtnEditComp');
            $this->addItem('BtnAddComp');
        }
        
        /**
         * Lekérdezi a kompetenciát URL alapján.
         * @param string $url => Kompetencia URL.
         * @param int $lId => Nyelv azonosító.
         * @return array
         */
        public function findCompetenceByUrl($url,$lId)
        {
                $query="SELECT kompetencia_id,
                                            nyelv_id,
                                            kompetencia_nev,
                                            kompetencia_link,
                                            kompetencia_leiras,
                                            kompetencia_meta_kulcsszo,
                                            kompetencia_tartalom,
                                            kompetencia_create_date,
                                            kompetencia_modositas_datum
                               FROM kompetencia
                               WHERE kompetencia_link='".mysql_real_escape_string($url)."' AND
                                            kompetencia_aktiv=1 AND
                                            kompetencia_torolt=0 AND
                                            nyelv_id=".(int)$lId."
                               LIMIT 1";
                return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        }
        
        /**
         * Lekérdezi a user kompetenciáit USERID alapján.
         * @param string $id => Kompetencia USERID.
         * @param int $lId => Nyelv azonosító.
         * @return array
         */
        public function findCompetencesByUserId($id,$lId)
        {
            try{
                $query="SELECT user_attr_kompetencia_user_id, kompetencia.kompetencia_nev, user_attr_kompetencia_valasz, user_attr_kompetencia_tesztbol, kompetencia_id, kompetencia_szinkod
                               FROM user_attr_kompetencia
                               LEFT JOIN kompetencia
                               ON kompetencia.kompetencia_id = user_attr_kompetencia.user_attr_kompetencia_kompetencia_id
                               WHERE user_attr_kompetencia_user_id='".mysql_real_escape_string($id)."'
                               AND user_attr_kompetencia_torolt=0 AND
                                            nyelv_id=".(int)$lId;
                return $this->_DB->prepare($query)->query_select()->query_result_array();
                }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
        }
        
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
        /**
         * Növeli eggyel a kompetencia megtekintésének számát.
         * @param int $compId => Kompetencia azonosító.
         * @param int $lId => Nyelv azonosító.
         */
        public function updateViews($compId,$lId)
        {
                $query="UPDATE kompetencia
                               SET kompetencia_megtekintve=kompetencia_megtekintve+1
                               WHERE kompetencia_id=".(int)$compId." AND
                               nyelv_id=".(int)$lId."
                               LIMIT 1";
                $this->_DB->prepare($query)->query_execute();
        }
       
        
       public function deleteComp($compId){
           try{
           $userId=$this->userId;
           $query="UPDATE user_attr_kompetencia
                   SET user_attr_kompetencia_torolt='1', user_attr_kompetencia_tesztbol='0'
                   WHERE user_attr_kompetencia_user_id='".$userId."'
                   AND user_attr_kompetencia_kompetencia_id='".mysql_real_escape_string($compId)."'";
           
           return $this->_DB->prepare($query)->query_execute();
           }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
       }
       
       public function editComp($compId, $valasz){
           try{
           $userId=$this->userId;
           $query="UPDATE user_attr_kompetencia
                   SET user_attr_kompetencia_valasz='".mysql_real_escape_string($valasz)."'
                   WHERE user_attr_kompetencia_user_id='".$userId."'
                   AND user_attr_kompetencia_kompetencia_id='".mysql_real_escape_string($compId)."'";
           
           return $this->_DB->prepare($query)->query_execute();
           }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
       }
       
       public function addComp($compId, $valasz, $tesztbol=0){
           try{
           $userId=$this->userId;
           $query="INSERT INTO user_attr_kompetencia
                   (user_attr_kompetencia_user_id, user_attr_kompetencia_kompetencia_id, user_attr_kompetencia_torolt, user_attr_kompetencia_tesztbol, user_attr_kompetencia_valasz)
                   VALUES (".$userId.",".mysql_real_escape_string($compId).",0,".mysql_real_escape_string($tesztbol).",'".mysql_real_escape_string($valasz)."')
                   ON DUPLICATE KEY UPDATE
                   user_attr_kompetencia_torolt='0', user_attr_kompetencia_tesztbol='".mysql_real_escape_string($tesztbol)."', user_attr_kompetencia_valasz='".mysql_real_escape_string($valasz)."'"
                   ;
           return $this->_DB->prepare($query)->query_insert();
           }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
       }
       
       public function addCompFromTest($compId, $valasz, $tesztbol=0, $userId){
           try{
           
           $query="INSERT INTO user_attr_kompetencia
                   (user_attr_kompetencia_user_id, user_attr_kompetencia_kompetencia_id, user_attr_kompetencia_torolt, user_attr_kompetencia_tesztbol, user_attr_kompetencia_valasz)
                   VALUES (".$userId.",".mysql_real_escape_string($compId).",0,".mysql_real_escape_string($tesztbol).",'".mysql_real_escape_string($valasz)."')
                   ON DUPLICATE KEY UPDATE
                   user_attr_kompetencia_torolt='0', user_attr_kompetencia_tesztbol='".mysql_real_escape_string($tesztbol)."', user_attr_kompetencia_valasz='".mysql_real_escape_string($valasz)."'"
                   ;
           return $this->_DB->prepare($query)->query_insert();
           }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
       }
       
        
}