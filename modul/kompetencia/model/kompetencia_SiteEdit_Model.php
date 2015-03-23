<?php
class Kompetencia_SiteEdit_Model extends Page_Edit_Model
{
        protected $clientId;
        
        public function __construct()
        {
                $this->addDB('MYSQL_DB');
        }
        
        public function setClientId($clientId)
        {
            $this->clientId = (int)$clientId;
        }
        
        public function __addForm()
        {
            parent::__addForm();
            $this->addItem('BtnDeleteComp');
            $this->addItem('BtnAddComp');
        }
        
        
        public function findCompetencesByClientId($lId)
        {
            try{
                $query="SELECT ugyfel_attr_kompetencia_ugyfel_id, kompetencia.kompetencia_nev, ugyfel_attr_kompetencia_tesztbol, kompetencia_id, kompetencia_szinkod, kompetencia_link
                               FROM ugyfel_attr_kompetencia
                               LEFT JOIN kompetencia ON kompetencia.kompetencia_id = ugyfel_attr_kompetencia.ugyfel_attr_kompetencia_kompetencia_id
                               WHERE ugyfel_attr_kompetencia_ugyfel_id= ".(int)$this->clientId." AND kompetencia.kompetencia_aktiv = 1 AND kompetencia.kompetencia_torolt = 0
                               AND nyelv_id=".(int)$lId;
                
                return $this->_DB->prepare($query)->query_select()->query_result_array();
                }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
        }
        
        public function getAllCompetences($lId)
        {
            try{    
            $query="SELECT kompetencia_nev, kompetencia_id, kompetencia_szinkod, kompetencia_link, tipus
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
        
       
        
       public function deleteComp($compId){
           try{
           $clientId = $this->clientId;
           $query = "DELETE FROM ugyfel_attr_kompetencia WHERE ugyfel_attr_kompetencia_ugyfel_id = ".(int)$clientId." AND ugyfel_attr_kompetencia_kompetencia_id = ".(int)$compId;
           
           return $this->_DB->prepare($query)->query_execute();
           }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
       }
       
       public function addComp($compId){
           try{
           $clientId = $this->clientId;
           $query = "INSERT INTO ugyfel_attr_kompetencia
                   (ugyfel_attr_kompetencia_ugyfel_id, ugyfel_attr_kompetencia_kompetencia_id)
                   VALUES (".(int)$clientId.",".(int)$compId.")
                   ON DUPLICATE KEY UPDATE
                   ugyfel_attr_kompetencia_ugyfel_id=".(int)$clientId.", ugyfel_attr_kompetencia_kompetencia_id=".(int)$compId
                   ;
           return $this->_DB->prepare($query)->query_insert();
           }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
       }
       
       public function addCompFromTest($compId, $tesztbol, $clientId){
           try{
           
           $query = "INSERT INTO ugyfel_attr_kompetencia
                   (ugyfel_attr_kompetencia_ugyfel_id, ugyfel_attr_kompetencia_kompetencia_id, ugyfel_attr_kompetencia_tesztbol)
                   VALUES (".(int)$clientId.",".(int)$compId.",1)
                   ON DUPLICATE KEY UPDATE
                   ugyfel_attr_kompetencia_ugyfel_id=".(int)$clientId.", ugyfel_attr_kompetencia_kompetencia_id=".(int)$compId.", ugyfel_attr_kompetencia_tesztbol = 1"
                   ;
           return $this->_DB->prepare($query)->query_insert();
           }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
       }
       
       public function addSzektorFromTest($sID, $clientId, $eredmeny){
           try{
           
           $query = "INSERT INTO ugyfel_attr_szektorteszt
                   (ugyfel_id, szektor_id, eredmeny)
                   VALUES (".(int)$clientId.",".(int)$sID.", '".mysql_real_escape_string($eredmeny)."')
                   ON DUPLICATE KEY UPDATE
                   ugyfel_id=".(int)$clientId.", szektor_id=".(int)$sID.", eredmeny='".mysql_real_escape_string($eredmeny)."'"
                   ;
           
           return $this->_DB->prepare($query)->query_insert();
           }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
           
            }
       }
       
       
       public function checkIfCompExistsByName($name)
       {
           
           try
           {
            $query = "SELECT kompetencia_id FROM kompetencia WHERE LOWER(kompetencia_nev) = '".mb_strtolower(mysql_real_escape_string($name),'UTF-8')."'";
            $this->_DB->prepare($query)->query_select();
            
            return true;
           } catch (Exception_MYSQL_Null_Rows $e) {
               return false;
           }
       }
       
       public function addOwnComp($name){
           try{
           $clientId = $this->clientId;
           $query = "INSERT INTO kompetencia
                     SET nyelv_id = 1, kompetencia_nev = '".ucfirst(mb_strtolower(mysql_real_escape_string($name),'UTF-8'))."', kompetencia_create_date = NOW(),
                         kompetencia_letrehozo = ".$this->clientId.", tipus='ugyfel', checked = 0
                     "
                   ;
           return $this->_DB->prepare($query)->query_insert();
           }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
       }
       
       public function validateCompNev($nev)
       {
           if(empty($nev) || strlen($nev) < 5)
           {
             return false;  
           }else{
             return true;
           }
       }
       
        
}