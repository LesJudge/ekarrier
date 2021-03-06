<?php
class Enceg_Show_Model extends Page_Edit_Model {
    
    public function __construct(){
        $this->addDB("MYSQL_DB");
        
    }
    
    public function __addForm() {
        parent::__addForm();
        $file = $this->addItem("File");
		$file->_verify["maxsize"] = Create::convertToBytes(ini_get('upload_max_filesize')."B");
		$file->_action_type = & $_FILES;
		$file->_verify["picture"] = true;
    }
    
    public function getJobsByCompanyId($id)
    {
        try
        {
        $date = date("Y-m-d");
            $query = "SELECT ah.allashirdetes_id AS ahID,
                        ah.link AS link,
                        mk.baloldal AS leftSide,
                        mk.jobboldal AS rightSide,
                        mk.kategoria_cim AS subCat,
                        IF(ah.kezdes_datum <= '".$date."' AND ah.lejarati_datum >= '".$date."' AND ah.allashirdetes_aktiv = 1,'true','false') AS aktiv,
                        cv.cim_varos_nev AS varos,
                        m.munkakor_nev AS munkakor,
                        (
                         SELECT kategoria_cim
                         FROM munkakor_kategoria mk2
                         WHERE mk2.baloldal < leftSide AND mk2.jobboldal > rightSide AND szint = 1
                        ) AS mainCat,
                        (
                         SELECT COUNT(uaam.ugyfel_id)
                         FROM ugyfel_attr_allashirdetes_megjelolt uaam
                         WHERE uaam.allashirdetes_id = ah.allashirdetes_id
                        ) AS markerCnt
                  FROM allashirdetes ah
                  INNER JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = ah.allashirdetes_id
                  INNER JOIN munkakor m ON m.munkakor_id = aam.munkakor_id
                  INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = m.munkakor_id
                  INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id AND mk.szint = 2
                  LEFT JOIN cim_varos cv ON ah.cim_varos_id = cv.cim_varos_id
                  WHERE ah.ceg_id = ".(int)$id." AND ah.allashirdetes_torolt = 0
                  ORDER BY ah.letrehozas_timestamp DESC
                  ";
            $result = $this->_DB->prepare($query)->query_select()->query_result_array();
            
            $returnArray = array();
        
            foreach ($result as $key => $value) {
                $query = "SELECT ugyfel.ugyfel_id AS uID, uaam.kompetenciarajz_id AS krID
                          FROM ugyfel_attr_allashirdetes_megjelolt uaam
                          INNER JOIN ugyfel ON ugyfel.ugyfel_id = uaam.ugyfel_id
                          WHERE uaam.allashirdetes_id = ".(int)$value['ahID']."
                        ";
                try{
                    $arr = $this->_DB->prepare($query)->query_select()->query_result_array();
                }catch(Exception_MYSQL_Null_Rows $e)
                {
                    $arr=array();
                }
                catch(Exception_MYSQL $e)
                {
                    $arr=array();
                }
                
                $returnArray["".$value['ahID'].""]['ahID'] = $value['ahID'];
                $returnArray["".$value['ahID'].""]['aktiv'] = $value['aktiv'];
                $returnArray["".$value['ahID'].""]['varos'] = $value['varos'];
                $returnArray["".$value['ahID'].""]['link'] = $value['link'];
                $returnArray["".$value['ahID'].""]['subCat'] = $value['subCat'];
                $returnArray["".$value['ahID'].""]['munkakor'] = $value['munkakor'];
                $returnArray["".$value['ahID'].""]['mainCat'] = $value['mainCat'];
                $returnArray["".$value['ahID'].""]['markerCnt'] = $value['markerCnt'];
                $returnArray["".$value['ahID'].""]['ugyfelek'] = $arr;
            }
            
            return $returnArray;
            
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
            return array();
        }
    }
    
    public function getFoldersByCompanyId($cID){
        try{
            $query = "SELECT cam.mappa_nev AS nev, cam.ceg_attr_mappa_id AS fID FROM ceg_attr_mappa cam WHERE cam.ceg_id = ".(int)$cID." AND cam.ceg_attr_mappa_torolt = 0";
            $result = $this->_DB->prepare($query)->query_select()->query_result_array();
            
            $returnArray = array();
            
            foreach ($result as $key => $value) {
                $query = "SELECT ugyfel.ugyfel_id AS uID, kr.kompetenciarajz_id AS krID
                          FROM ceg_attr_mappa_kompetenciarajz camk
                          INNER JOIN kompetenciarajz kr ON kr.kompetenciarajz_id = camk.kompetenciarajz_id
                          INNER JOIN ugyfel ON ugyfel.ugyfel_id = kr.ugyfel_id
                          WHERE camk.mappa_id = ".(int)$value['fID']."
                        ";
                try{
                    $arr = $this->_DB->prepare($query)->query_select()->query_result_array();
                }catch(Exception_MYSQL_Null_Rows $e)
                {
                    $arr=array();
                }
                catch(Exception_MYSQL $e)
                {
                    $arr=array();
                }
                
                $returnArray["".$value['fID'].""]['mappaNev'] = $value['nev'];
                $returnArray["".$value['fID'].""]['ugyfelek'] = $arr;
            }
            
            return $returnArray;
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
            return array();
        }
        
    }
    
    public function uploadPic($cID){
        $query = "UPDATE ceg SET ceg_kep = ".Create::upload_file($this->_params["File"]->_value)." WHERE ceg_id = ".(int)$cID."";
        $this->_DB->prepare($query)->query_update();
    }
    
    public function updateDescription($desc,$cID){
        $query = "UPDATE ceg SET tartalom = '".  mysql_real_escape_string($desc)."' WHERE ceg_id = ".(int)$cID."";
        $this->_DB->prepare($query)->query_update();
    }
    
    
    public function getCompanyData($cID){
        try{
            $query = "SELECT tartalom, ceg_kep, link
                      FROM ceg 
                      WHERE ceg_id = ".(int)$cID." AND ceg_aktiv = 1 AND ceg_torolt = 0
                      LIMIT 1
                        ";
            
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }catch(Exception_MYSQL $e){
            return array();
        }
    }
    
    public function getCompanyCreateDate($companyID){
        try{
            $query = "SELECT DATE_FORMAT(`letrehozas_timestamp`, '%Y-%m-%d') AS letrehozas_datum
                      FROM ceg
                      WHERE ceg_id = ".(int)$companyID."
                        ";
    
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        }catch(Exception_MYSQL $e){
            return array();
        }
    }
    
    
    
    public function getStat($companyID,$start,$end){
        
        try{
            try{
                $query = "SELECT am.ugyfel_id AS id
                          FROM allashirdetes_megtekintes am
                          INNER JOIN allashirdetes a ON a.allashirdetes_id = am.allashirdetes_id
                          WHERE a.ceg_id = ".(int)$companyID." AND am.datum >= '". mysql_real_escape_string($start)."' AND am.datum <= '". mysql_real_escape_string($end)."'
                            ";
                $resultAh = $this->_DB->prepare($query)->query_select()->query_result_array();
            }catch(Exception_MYSQL_Null_Rows $e){
                $resultAh = array();
            }
            //$ahSzum = $result['cnt'];
            try{
                $query = "SELECT cm.ugyfel_id AS id
                          FROM ceg_megtekintes cm
                          WHERE cm.ceg_id = ".(int)$companyID." AND cm.datum >= '". mysql_real_escape_string($start)."' AND cm.datum <= '". mysql_real_escape_string($end)."'
                            ";
                $resultProfil = $this->_DB->prepare($query)->query_select()->query_result_array();
            }catch(Exception_MYSQL_Null_Rows $e){
                $resultProfil = array();
            }
            //$profilSzum = $result['cnt'];
            
            $finalArr = array();
            
            foreach ($resultAh as $key => $value) {
                $finalArr[] = $value['id'];
            }
            
            foreach ($resultProfil as $key => $value) {
                $finalArr[] = $value['id'];
            }
            
            $finalArr = array_unique($finalArr);
            
            //$return['ah'] = $ahSzum;
            //$return['profil'] = $profilSzum;
            return $finalArr;
        }catch(Exception_MYSQL $e){
            return 'Hiba';
        }
    }
    
    public function checkDates($start,$end){
        if(strtotime($start) === false || strtotime($end) === false){
            return false;
        }
            return true;
    }
    
    public function getActiveClientsSum(){
        try{
            
            $query = "SELECT COUNT(ugyfel_id) AS cnt
                      FROM ugyfel
                      WHERE ugyfel_aktiv = 1 AND ugyfel_torolt = 0
                        ";
            $result = $this->_DB->prepare($query)->query_select()->query_fetch_array();
            return $result['cnt'];
            
        }catch(Exception_MYSQL $e){
            return 'Hiba';
        }
    }
    
}
?>