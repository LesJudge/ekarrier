<?php
class Kompetencia_SiteRajzShow_Model extends Page_Edit_Model
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
        
        public function getCompRajzById($id,$mod = "default")
        {
            if($mod === "default")
            {
                $query = "
                        SELECT k.kompetenciarajz_id AS krID, k.kompetenciarajz_nev AS kompetenciarajz_nev, CONCAT (u.vezeteknev, ' ', u.keresztnev) AS nev, k.ugyfel_id AS uID
                        FROM kompetenciarajz k
                        INNER JOIN ugyfel u ON u.ugyfel_id = k.ugyfel_id
                        WHERE k.kompetenciarajz_id = ".(int)$id."
                        AND k.ugyfel_id = ".(int)$this->_clientID."
                        LIMIT 1    
                        ";
            }

            if($mod === "ceg")
            {
                $query = "
                        SELECT k.kompetenciarajz_id AS krID, u.ugyfel_id AS uID, k.kompetenciarajz_nev AS kompetenciarajz_nev, CONCAT (u.vezeteknev, ' ', u.keresztnev) AS nev
                        FROM kompetenciarajz k
                        INNER JOIN ugyfel u ON u.ugyfel_id = k.ugyfel_id
                        WHERE k.kompetenciarajz_id = ".(int)$id."
                        LIMIT 1    
                        ";
            }
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
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
        
        public function addCompanyToViewed($id,$cID)
        {
            try{
                $query = "SELECT megtekintve_ceg
                          FROM kompetenciarajz
                          WHERE kompetenciarajz_id=".(int)$id."
                          LIMIT 1
                                            ";
                $result = $this->_DB->prepare($query)->query_select()->query_fetch_array();
                
                $result = unserialize($result['megtekintve_ceg']);
                
                //ha tömb, tehát már mentettünk bele
                if(is_array($result))
                {
                    //ha a cég már megtekintette
                    if(!in_array((int)$cID,$result))
                    {  
                        $result[] = $cID;
                    }
                    
                    $query = "UPDATE kompetenciarajz
                              SET megtekintve_ceg='".  serialize($result)."'
                              WHERE kompetenciarajz_id =".(int)$id;
                    $ins = $this->_DB->prepare($query)->query_insert();
                }else{
                    //ha nem tömb
                    $result[] = $cID;
                    $query = "UPDATE kompetenciarajz
                              SET megtekintve_ceg='".serialize($result)."'
                              WHERE kompetenciarajz_id =".(int)$id;
                    $ins = $this->_DB->prepare($query)->query_insert();
                }
            }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            }
        }
        
    public function createFolder($companyID, $name)
    {
        $query = "INSERT INTO ceg_attr_mappa SET ceg_id = ".(int)$companyID.", mappa_nev = '".  mysql_real_escape_string($name)."'";
        $this->_DB->prepare($query)->query_insert();
    }
    
    public function checkIfFolderExistsByName($companyID, $name)
       {
           try
           {
            $query = "SELECT mappa_nev FROM ceg_attr_mappa WHERE mappa_nev = '".  mysql_real_escape_string($name)."' AND ceg_id = ".(int)$companyID;
            $this->_DB->prepare($query)->query_select();
            return true;
           } catch (Exception_MYSQL_Null_Rows $e) {
               return false;
           }
       }
       
   public function getFolders($companyID)
   {
      return $this->getSelectValues('ceg_attr_mappa', 
                                          'mappa_nev', 
                                          ' AND ceg_id = '.(int)$companyID.' ', 
                                          '', 
                                          false, 
                                          array('' => '--Válasszon!--'));
   }
   
   public function addDrawToFolder($folderID, $krID)
   {
        $query = "INSERT INTO ceg_attr_mappa_kompetenciarajz SET mappa_id = ".(int)$folderID.", kompetenciarajz_id = ".(int)$krID." ON DUPLICATE KEY UPDATE kompetenciarajz_id = ".(int)$krID;
        $this->_DB->prepare($query)->query_insert();
   }
        
        
        
        
}