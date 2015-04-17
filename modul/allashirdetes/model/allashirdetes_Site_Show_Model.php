<?php
class Allashirdetes_Site_Show_Model extends Model
{
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
    }
    /**
     * Azonosító alapján lekérdezi az álláshirdetés adatait.
     * @param int $id
     * @return array
     * @throws Exception_MYSQL
     * @throws Exception_MYSQL_Null_Rows
     */
    public function findPostingJobById($id)
    {
        $query = "SELECT 
                        a.allashirdetes_id,
                        a.hirdeto,
                        a.egyedi,
                        a.megnevezes,
                        a.ismerteto,
                        a.jelentkezes_modja,
                        a.ellenorzott,
                        a.utca,
                        a.hazszam,
                        a.mas_hirdetese,
                        a.mas_hirdetese_link,
                        c.nev,
                        c.link,
                        cv.cim_varos_nev,
                        cm.cim_megye_nev,
                        a.munkavegzes_jellege,
                        a.munkaber,
                        a.probaido,
                        a.egyeb,
                        a.jelentkezes_hatarideje,
                        a.munkakezdes_ideje,
                        a.egyeb,
                        a.letrehozas_timestamp,
                        sz.szektor_nev,
                        p.pozicio_nev
                        
                  FROM
                        allashirdetes a
                            LEFT JOIN
                        ceg c ON a.ceg_id = c.ceg_id
                            LEFT JOIN
                        cim_varos cv ON a.cim_varos_id = cv.cim_varos_id
                            LEFT JOIN
                        cim_megye cm ON a.cim_megye_id = cm.cim_megye_id
                            LEFT JOIN
                        szektor sz ON sz.szektor_id = a.szektor_id
                            LEFT JOIN
                        pozicio p ON p.pozicio_id = a.pozicio_id
                            /*INNER JOIN
                        munkarend m ON a.munkarend_id = m.munkarend_id*/
                  WHERE
                        a.allashirdetes_id = " . (int)$id . "
                            AND a.allashirdetes_aktiv = 1
                            AND a.allashirdetes_torolt = 0
                  LIMIT 1";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    /**
     * Megjelöli az adott álláshirdetést.
     * @param int $userId Felhasználó azonosító
     * @param int $jobId Álláshirdetés azonosító
     * @return int
     * @throws Exception_MYSQL_Null_Affected_Rows
     */
    public function markPostingJob($userId, $jobId, $krajz)
    {
        $query = 'INSERT INTO ugyfel_attr_allashirdetes_megjelolt (ugyfel_id, allashirdetes_id, kompetenciarajz_id, jeloles_date) VALUES 
                 (' . (int)$userId . ', ' . (int)$jobId . ', '.(int)$krajz.', NOW())';
        return $this->_DB->prepare($query)->query_insert();
    }
    /**
     * Eltávolítja a jelölést az adott álláshirdetésről.
     * @param int $userId Felhasználó azonosító
     * @param int $jobId Álláshirdetés azonosító
     */
    public function unmarkPostingJob($userId, $jobId)
    {
        $query = 'DELETE FROM ugyfel_attr_allashirdetes_megjelolt WHERE ugyfel_id = ' . (int)$userId . 
                 ' AND allashirdetes_id = ' . (int)$jobId . ' LIMIT 1';
        $this->_DB->prepare($query)->query_execute();
    }
    
    public function favouritePostingJob($userId, $jobId)
    {
        $query = 'INSERT INTO ugyfel_attr_allashirdetes_kedvenc (ugyfel_id, allashirdetes_id, jeloles_date) VALUES 
                 (' . (int)$userId . ', ' . (int)$jobId . ', NOW())';
        return $this->_DB->prepare($query)->query_insert();
    }
    
    public function unfavouritePostingJob($userId, $jobId)
    {
        $query = 'DELETE FROM ugyfel_attr_allashirdetes_kedvenc WHERE ugyfel_id = ' . (int)$userId . 
                 ' AND allashirdetes_id = ' . (int)$jobId . ' LIMIT 1';
        $this->_DB->prepare($query)->query_execute();
    }
    /**
     * Megvizsgálja, hogy az adott álláshirdetés meg lett-e jelölve a felhasználó által.
     * @param int $userId Felhasználó azonosító
     * @param int $jobId Álláshirdetés azonosító
     * @return boolean
     */
    public function isMarkedByUser($userId, $jobId)
    {
        $query = 'SELECT ugyfel_id FROM ugyfel_attr_allashirdetes_megjelolt WHERE ugyfel_id = ' . (int)$userId . 
                 ' AND allashirdetes_id = ' . (int)$jobId . ' LIMIT 1';
        $queryObj = $this->_DB->prepare($query);
        $queryObj->query_execute();
        return (boolean)$queryObj->query_fetch_array('ugyfel_id');
    }
    
    public function isFavouritedByUser($userId, $jobId)
    {
        $query = 'SELECT ugyfel_id FROM ugyfel_attr_allashirdetes_kedvenc WHERE ugyfel_id = ' . (int)$userId . 
                 ' AND allashirdetes_id = ' . (int)$jobId . ' LIMIT 1';
        $queryObj = $this->_DB->prepare($query);
        $queryObj->query_execute();
        return (boolean)$queryObj->query_fetch_array('ugyfel_id');
    }
    
    public function findKompetenciaRajzokByUgyfelID($id)
    {
        try{
            $query = "
                    SELECT kompetenciarajz_id AS ID, kompetenciarajz_nev AS nev
                    FROM kompetenciarajz
                    WHERE ugyfel_id = ".(int)$id    
                    ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }    
    }
    
    public function findKompetenciaByJobId($ahID){
        try{
            $query = "
                    SELECT k.kompetencia_nev AS nev
                    FROM allashirdetes_attr_kompetencia aak
                    INNER JOIN kompetencia k ON k.kompetencia_id = aak.kompetencia_id
                    WHERE aak.allashirdetes_id = ".(int)$ahID." AND k.kompetencia_aktiv = 1 AND k.kompetencia_torolt = 0"    
                    ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }  
    }
    
    public function updateJobView($clientID, $ahID){
        try{
            
            $query = "INSERT INTO allashirdetes_megtekintes
                      SET allashirdetes_id = ".(int)$ahID.", ugyfel_id = ".(int)$clientID.", datum = NOW()
                      ON DUPLICATE KEY UPDATE ugyfel_id = ".(int)$clientID."
                     ";
            $this->_DB->prepare($query)->query_insert();
        }catch(Exception_MYSQL $e){   
        }
    }
    
    
    
    
}