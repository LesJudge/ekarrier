<?php
class Ceg_ShowCeg_Model extends Page_Edit_Model
{
        
        public function __construct()
        {
                $this->addDB('MYSQL_DB');
        }
        
        /**
         * Lekérdezi a cég adatait URL alapján.
         * @param string $url => A cég URL-je.
         * @param int $lId => Nyelvi azonosító.
         * @return array
         */
        public function findCompanyByUrl($url,$lId)
        {/*
                $query="SELECT ceg_id,
                                            nyelv_id,
                                            user_id,
                                            ceg_nev,
                                            ceg_link,
                                            ceg_leiras,
                                            ceg_meta_kulcsszo,
                                            ceg_tartalom
                               FROM ceg
                               WHERE ceg_link='".mysql_real_escape_string($url)."' AND
                                           ceg_aktiv=1 AND
                                           ceg_torolt=0 AND
                                           nyelv_id=".(int)$lId."
                               LIMIT 1";
           */     
                $query="SELECT ceg.ceg_id,
                                            nev,
                                            link,
                                            leiras,
                                            meta_kulcsszo,
                                            tartalom,
                                            CONCAT(ci.iranyitoszam, ' ', cv.cim_varos_nev, ' ', csz.utca, ' ', csz.hazszam) AS szhely
                                            
                               FROM ceg
                               LEFT JOIN ceg_szekhely csz ON csz.ceg_id = ceg.ceg_id
                               LEFT JOIN cim_iranyitoszam ci ON ci.cim_iranyitoszam_id = csz.cim_iranyitoszam_id
                               LEFT JOIN cim_varos cv ON cv.cim_varos_id = csz.cim_varos_id
                               WHERE link='".mysql_real_escape_string($url)."' AND
                                           ceg_aktiv=1 AND
                                           ceg_torolt=0
                               LIMIT 1";
                return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        }
        
        
        public function getCompanyTelephelyek($id)
        {
            try
            {
                $query="SELECT ceg.ceg_id,
                               CONCAT(ci.iranyitoszam, ' ', cv.cim_varos_nev, ' ', ct.utca, ' ', ct.hazszam) AS thely
                               FROM ceg
                               INNER JOIN ceg_telephely ct ON ct.ceg_id = ceg.ceg_id
                               INNER JOIN cim_iranyitoszam ci ON ci.cim_iranyitoszam_id = ct.cim_iranyitoszam_id
                               INNER JOIN cim_varos cv ON cv.cim_varos_id = ct.cim_varos_id
                               WHERE ceg.ceg_id=".(int)$id." AND
                                           ceg_aktiv=1 AND
                                           ceg_torolt=0
                               LIMIT 1";
                return $this->_DB->prepare($query)->query_select()->query_result_array();
                
                
            } catch (Exception_MYSQL_Null_Rows $e) {
                return '';
            }
            
            
        }


        /**
         * Lekérdezi a céghez tartozó álláshirdetéseket.
         * @param int $companyId
         * @param int $lId
         * @return mixed (false|array)
         */
        public function findJobsByCompanyId($companyId,$lId)
        {
                try
                {/*
                        $query="SELECT allashirdetes_id,
                                                    nyelv_id,
                                                    ceg_id,
                                                    munkakor_id,
                                                    allashirdetes_nev,
                                                    allashirdetes_link,
                                                    allashirdetes_tartalom,
                                                    allashirdetes_create_date
                                       FROM allashirdetes
                                       WHERE ceg_id=".(int)$companyId." AND
                                                    allashirdetes_aktiv=1 AND
                                                    allashirdetes_torolt=0 AND
                                                    nyelv_id=".(int)$lId;*/
                    
                 $query="SELECT allashirdetes.allashirdetes_id AS allashirdetes_id,
                                ceg_id,
                                /*munkakor.munkakor_id,*/
                                megnevezes,
                                link,
                                ismerteto,
                                letrehozas_timestamp,
                                munkakor.munkakor_nev AS munkakor_nev
                                /*munkakor.munkakor_link AS munkakor_link*/
                        FROM allashirdetes
                        INNER JOIN allashirdetes_attr_munkakor ON allashirdetes_attr_munkakor.allashirdetes_id = allashirdetes.allashirdetes_id
                        INNER JOIN munkakor ON munkakor.munkakor_id = allashirdetes_attr_munkakor.munkakor_id
                        WHERE ceg_id=".(int)$companyId." AND
                              allashirdetes_aktiv=1 AND
                              allashirdetes_torolt=0";
                 
                 
                        return $this->_DB->prepare($query)->query_select()->query_result_array();
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return false;
                }
        }
        
    /**
     * Növeli eggyel a cég megtekintés számát.
     * @param int $companyId => Cég azonosító.
     * @param int $lId => Nyelv azonosító.
     */
    public function updateViews($companyId,$lId)
    {
            $query="UPDATE ceg SET megtekintve = megtekintve+1 WHERE ceg_id=" . (int)$companyId . " LIMIT 1";
            $this->_DB->prepare($query)->query_execute();
    }
}