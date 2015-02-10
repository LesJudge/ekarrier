<?php
class Allaskereses_Allashirdetes_Model extends Model
{
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
    }
    /**
     * Azonosító alapján lekérdezi az álláshirdetés adatait.
     * @param int $id
     * @return array
     * @throws Exception_MYSQL_Null_Rows
     */
    public function findPostingJobById($id)
    {
        $query = "SELECT * FROM allashirdetes WHERE allashirdetes_id = " . (int)$id . 
                 " AND allashirdetes_aktiv = 1 AND allashirdetes_torolt = 0 LIMIT 1";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    
    public function markPostingJob($userId, $jobId)
    {
        $query = 'INSERT INTO user_allashirdetes_megjelolt (user_id, allashirdetes_id) VALUES 
                 (' . (int)$userId . ', ' . (int)$jobId . ')';
        return $this->_DB->prepare($query)->query_insert();
    }
    
    public function unmarkPostingJob($userId, $jobId)
    {
        $query = 'DELETE FROM user_allashirdetes_megjelolt WHERE user_id = ' . (int)$userId . 
                 ' AND allashirdetes_id = ' . (int)$jobId . ' LIMIT 1';
        $this->_DB->prepare($query)->query_execute();
    }
    
    public function isMarkedByUser($userId, $jobId)
    {
        $query = 'SELECT user_id FROM user_allashirdetes_megjelolt WHERE user_id = ' . (int)$userId . 
                 ' AND allashirdetes_id = ' . (int)$jobId . ' LIMIT 1';
        $queryObj = $this->_DB->prepare($query);
        $queryObj->query_execute();
        return (boolean)$queryObj->query_fetch_array('user_id');
    }
}