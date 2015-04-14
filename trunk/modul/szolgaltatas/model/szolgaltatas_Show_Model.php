<?php
class Szolgaltatas_Show_Model extends Page_Edit_Model {

    public function __construct(){
        $this->addDB("MYSQL_DB");
        
    }
    
    public function __addForm() {
        parent::__addForm();
    }
    
    public function getSzolgaltatasok($type)
    {
        try{
            if($type==='company'){
                $ifString = " AND szolgaltatas_tipus = 'ceg'";
            }
            if($type==='client'){
                $ifString = " AND szolgaltatas_tipus = 'ugyfel'";
            }
            
            $query = "SELECT nev, leiras, szolgaltatas_id AS ID
                  FROM szolgaltatas
                  WHERE szolgaltatas_aktiv = 1 AND szolgaltatas_torolt = 0 ".$ifString."
                  ORDER BY nev ASC
                  ";

            return $this->_DB->prepare($query)->query_select()->query_result_array();
            
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
    
public function getFolders($companyID){
    try{
            $query = "SELECT mappa_nev AS nev, ceg_attr_mappa_id AS ID
                  FROM ceg_attr_mappa
                  WHERE ceg_attr_mappa_torolt = 0 AND ".(int)$companyID."
                  ORDER BY mappa_nev ASC
                  ";

            $result = $this->_DB->prepare($query)->query_select()->query_result_array();
            
            $returnArray = array();
        
            foreach ($result as $key => $value) {
                $query = "SELECT ugyfel.ugyfel_id AS uID, camk.kompetenciarajz_id AS krID
                          FROM ceg_attr_mappa_kompetenciarajz camk
                          LEFT JOIN kompetenciarajz kr ON kr.kompetenciarajz_id = camk.kompetenciarajz_id
                          LEFT JOIN ugyfel ON ugyfel.ugyfel_id = kr.ugyfel_id
                          WHERE camk.mappa_id = ".(int)$value['ID']."
                        ";
                
                try{
                    $arr = $this->_DB->prepare($query)->query_select()->query_result_array();
                }catch(Exception_MYSQL_Null_Rows $e){
                   
                    $arr=array();
                }
                catch(Exception_MYSQL $e){
                    $arr=array();
                }
                $returnArray["".$value['ID'].""]['nev'] = $value['nev'];
                $returnArray["".$value['ID'].""]['ID'] = $value['ID'];
                $returnArray["".$value['ID'].""]['ugyfelek'] = $arr;
            }
            return $returnArray;
            
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
        catch(Exception_MYSQL $e){
            return array();
        }
}
    
    public function saveOrder($companyID, $serviceID, $clientsFromFolder, $clientsFromMarkers)
    {
        //$foldersSer = serialize($folders);
        
        $clientsFromFolder = serialize($clientsFromFolder);
        $clientsFromMarkers = serialize($clientsFromMarkers);
        
        /*$query = "INSERT INTO ceg_szolgaltatas_megrendeles SET ceg_id = ".(int)$companyID.", mappak = '".mysql_real_escape_string($foldersSer)."', szolgaltatas_id = ".(int)$serviceID.",
                  megrendeles_timestamp = NOW(), ceg_szolgaltatas_megrendeles_aktiv = 1, ceg_szolgaltatas_megrendeles_torolt = 0, statusz = 0
                    ";
        */
        $query = "INSERT INTO ceg_szolgaltatas_megrendeles SET ceg_id = ".(int)$companyID.", ugyfelek_mappakbol = '".mysql_real_escape_string($clientsFromFolder)."', ugyfelek_jelentkezettek = '".mysql_real_escape_string($clientsFromMarkers)."', szolgaltatas_id = ".(int)$serviceID.",
                  megrendeles_timestamp = NOW(), ceg_szolgaltatas_megrendeles_aktiv = 1, ceg_szolgaltatas_megrendeles_torolt = 0, statusz = 0
                    ";
        
        $ins = $this->_DB->prepare($query)->query_insert();
        
        /*
        foreach($folders as $key => $value){
            $query = "SELECT u.ugyfel_id AS ugyfelID
                    FROM ceg_attr_mappa cam
                    LEFT JOIN ceg_attr_mappa_kompetenciarajz camk ON cam.ceg_attr_mappa_id = camk.mappa_id
                    LEFT JOIN kompetenciarajz kr ON camk.kompetenciarajz_id = kr.kompetenciarajz_id
                    LEFT JOIN ugyfel u ON kr.ugyfel_id = u.ugyfel_id
                    WHERE cam.ceg_attr_mappa_id = ".(int)$value." GROUP BY u.ugyfel_id";
            
            $result = $this->_DB->prepare($query)->query_select()->query_result_array();
            $result = serialize($result);
            
            $query = "INSERT INTO szolgaltatas_megrendeles_ugyfelek
                      SET megrendeles_id = ".(int)$ins.", mappa_id = ".(int)$value.", ugyfelek = '".mysql_real_escape_string($result)."'";
            $this->_DB->prepare($query)->query_insert();
        }
        */
    }
    
    public function pendingOrderExists($companyID, $serviceID)
    {
        try{
            $query = "SELECT ceg_szolgaltatas_megrendeles_id
                  FROM ceg_szolgaltatas_megrendeles
                  WHERE ceg_szolgaltatas_megrendeles_torolt = 0
                        AND ceg_szolgaltatas_megrendeles_aktiv = 1
                        AND ceg_id = ".(int)$companyID."
                        AND szolgaltatas_id = ".(int)$serviceID."
                        AND statusz = 0
                  ";

            $this->_DB->prepare($query)->query_select()->query_result_array();
            
            return true;
            
        }catch(Exception_MYSQL_Null_Rows $e){
            return false;
        }
    }
    
    public function getPendingOrders($ID, $type)
    {
        try{
            if($type == 'company'){
                $query = "SELECT szolgaltatas_id
                      FROM ceg_szolgaltatas_megrendeles
                      WHERE ceg_szolgaltatas_megrendeles_torolt = 0
                            AND ceg_szolgaltatas_megrendeles_aktiv = 1
                            AND ceg_id = ".(int)$ID."
                            AND statusz = 0
                      ";
            }
            if($type == 'client'){
                $query = "SELECT szolgaltatas_id
                      FROM ugyfel_szolgaltatas_megrendeles
                      WHERE ugyfel_szolgaltatas_megrendeles_torolt = 0
                            AND ugyfel_szolgaltatas_megrendeles_aktiv = 1
                            AND ugyfel_id = ".(int)$ID."
                            AND statusz = 0
                      ";
            }
            $result = $this->_DB->prepare($query)->query_select()->query_result_array();
            
            $returnArray = array();
            foreach ($result as $key => $value){
                $returnArray[] = $value['szolgaltatas_id'];
            }
            
            return $returnArray;
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }
    }
    
    public function saveClientOrder($cID,$sID){
        $query = "INSERT INTO ugyfel_szolgaltatas_megrendeles
                  SET ugyfel_id = ".(int)$cID.", szolgaltatas_id = ".(int)$sID.", megrendeles_timestamp = NOW(),
                      ugyfel_szolgaltatas_megrendeles_aktiv = 1, ugyfel_szolgaltatas_megrendeles_torolt = 0, statusz = 0
                ";
        
        $this->_DB->prepare($query)->query_insert();
        
    }
}
?>