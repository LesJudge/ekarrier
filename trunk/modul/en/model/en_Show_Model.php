<?php
class En_Show_Model extends Page_Edit_Model {
    public $_totalCompRajzViews;


    public function __construct(){
        $this->addDB("MYSQL_DB");
        
    }
    
    public function __addForm() {
        parent::__addForm();
    }
    
    public function getTevkorokByClientId($id)
    {
        try
        {
        
            $query = "SELECT mk.kategoria_cim AS nev, mk.munkakor_kategoria_id AS ID, mk.kategoria_full_link AS link, uat.jeloles_date AS datum
                  FROM ugyfel_attr_tevkor uat
                  INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = uat.tevkor_id
                  WHERE uat.ugyfel_id = " . (int)$id . " AND mk.munkakor_kategoria_aktiv = 1 AND mk.munkakor_kategoria_torolt = 0
                  ORDER BY datum DESC
                  ";

            return $this->_DB->prepare($query)->query_select()->query_result_array();
            
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
            
        }
    }
    
    public function getNumberOfJobsOfTevkor($ids)
    {
        try
        {
        $IDstring = implode(", ",$ids);
        
        $query = "SELECT COUNT( DISTINCT (a.allashirdetes_id)) AS ahDB,
                        mk.munkakor_kategoria_id AS ID,
                        mk.kategoria_cim AS nev
                    FROM allashirdetes a
                    INNER JOIN allashirdetes_attr_munkakor aam ON a.allashirdetes_id = aam.allashirdetes_id
                    INNER JOIN munkakor m ON m.munkakor_id = aam.munkakor_id
                    INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = aam.munkakor_id
                    INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id
                    WHERE
                        a.lejarati_datum > '" . date('Y-m-d') . "' AND 
                        mk.munkakor_kategoria_id IN (".$IDstring.")
                        /*mk.munkakor_kategoria_id = " . (int)$jobId . " */ AND 
                        a.allashirdetes_aktiv = 1 AND a.allashirdetes_torolt = 0
                    GROUP BY mk.munkakor_kategoria_id
            ";
        
        return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
            
        }
    }
    
    public function saveStat($uID, $arr)
    {
        try
        {
          $query = "INSERT INTO ugyfel_attr_stats
                    SET ugyfel_id =".(int)$uID.", stat_allasintevkor_uj='". mysql_real_escape_string($arr)."'
                    ON DUPLICATE KEY UPDATE
                    stat_allasintevkor_uj='". mysql_real_escape_string($arr)."'
                    " ;

            return $this->_DB->prepare($query)->query_insert();

        }catch(Exception_MYSQL $e)
        {   
        }
    }
    
    public function getStat($uID)
    {
        try
        {
          $query = "SELECT stat_allasintevkor_uj
                  FROM ugyfel_attr_stats
                  WHERE ugyfel_id = " . (int)$uID . "
                  LIMIT 1
                  ";

          $result = $this->_DB->prepare($query)->query_select()->query_result_array();
            return $result[0];
            
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
            
        }
    }
    


    
    public function getMarkedJobsByClientId($id)
    {
        try
        {
          $query = "SELECT m.munkakor_nev AS mkNev, a.allashirdetes_id AS ID, a.link AS link, uaam.jeloles_date AS datum, c.nev AS cegNev
                  FROM ugyfel_attr_allashirdetes_megjelolt uaam
                  INNER JOIN allashirdetes a ON a.allashirdetes_id = uaam.allashirdetes_id
                  INNER JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = a.allashirdetes_id
                  INNER JOIN munkakor m ON aam.munkakor_id = m.munkakor_id
                  INNER JOIN ceg c ON c.ceg_id = a.ceg_id
                  WHERE uaam.ugyfel_id = " . (int)$id . " AND a.allashirdetes_aktiv = 1 AND a.allashirdetes_torolt = 0
                  ORDER BY datum DESC
                  ";

            return $this->_DB->prepare($query)->query_select()->query_result_array();
            
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
            
        }
    }
    

    public function getFavouriteJobsByClientId($id)
    {
        try
        {
            $query = "SELECT a.megnevezes AS allasNev,c.nev AS cegNev,uaak.jeloles_date AS datum, a.allashirdetes_id AS allasID, a.link AS allasLink
                  FROM ugyfel_attr_allashirdetes_kedvenc uaak
                  INNER JOIN allashirdetes a ON a.allashirdetes_id = uaak.allashirdetes_id
                  INNER JOIN ceg c ON c.ceg_id = a.ceg_id
                  WHERE uaak.ugyfel_id = " . (int)$id . "
                      AND a.allashirdetes_aktiv = 1 AND a.allashirdetes_torolt = 0
                      AND c.ceg_aktiv = 1 AND c.ceg_torolt = 0
                  ORDER BY datum DESC
                  ";

            return $this->_DB->prepare($query)->query_select()->query_result_array();
            
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
        }
    }
    
    public function findCompetencesByClientId($cID,$lId)
    {
        try
        {
            $query="SELECT ugyfel_attr_kompetencia_ugyfel_id, kompetencia.kompetencia_nev, ugyfel_attr_kompetencia_tesztbol, kompetencia_id, kompetencia_szinkod, kompetencia_link
                               FROM ugyfel_attr_kompetencia
                               LEFT JOIN kompetencia
                               ON kompetencia.kompetencia_id = ugyfel_attr_kompetencia.ugyfel_attr_kompetencia_kompetencia_id
                               WHERE ugyfel_attr_kompetencia_ugyfel_id= ".(int)$cID."
                               AND
                                            nyelv_id=".(int)$lId;
             return $this->_DB->prepare($query)->query_select()->query_result_array();
        }
        catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
        }
    }
    
    public function getAllCompRajzByClientId($cID)
    {
        try
        {
            $query = "
                    SELECT kompetenciarajz_id AS ID, kompetenciarajz_nev AS nev
                    FROM kompetenciarajz
                    WHERE ugyfel_id = ".(int)$cID."
                    LIMIT 5"   
                    ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }
        catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {    
        }
    }
        
    public function getSectorTestResultByClientId($cID)
    {
        try
        {
            $query = "
                    SELECT sz.szektor_nev AS szektorNev, uasz.eredmeny AS eredmeny
                    FROM ugyfel_attr_szektorteszt uasz
                    INNER JOIN szektor sz ON sz.szektor_id = uasz.szektor_id
                    WHERE uasz.ugyfel_id = ".(int)$cID."
                    LIMIT 1"   
                    ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
        }
    }

    public function getCompRajzViews($cID)
    {
        try
        {
        $arr = array();
        $total = 0;
        $query = "  SELECT kompetenciarajz_nev AS nev, megtekintve_ceg AS views
                    FROM kompetenciarajz
                    WHERE ugyfel_id = ".(int)$cID   
                    ;
                    
        $result = $this->_DB->prepare($query)->query_select()->query_result_array();
        
        foreach ($result as $key => $value) {
            $obj = unserialize($value['views']);
            
            $view = count($obj);
            $arr["".$view.""] = $value['nev'];
            $total+=$view;
        }
        
        $this->_totalCompRajzViews = $total;
        
        return $arr;
        }catch(Exception_MYSQL_Null_Rows $e)
        {
            return array();
        }
        catch(Exception_MYSQL $e)
        {
        }
        
    }
    
}
?>