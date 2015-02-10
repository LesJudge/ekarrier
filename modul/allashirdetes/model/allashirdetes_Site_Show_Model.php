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
                        m.munkarend_nev
                  FROM
                        allashirdetes a
                            LEFT JOIN
                        ceg c ON a.ceg_id = c.ceg_id
                            LEFT JOIN
                        cim_varos cv ON a.cim_varos_id = cv.cim_varos_id
                            INNER JOIN
                        munkarend m ON a.munkarend_id = m.munkarend_id
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
    public function markPostingJob($userId, $jobId)
    {
        $query = 'INSERT INTO ugyfel_attr_allashirdetes_megjelolt (ugyfel_id, allashirdetes_id) VALUES 
                 (' . (int)$userId . ', ' . (int)$jobId . ')';
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
}