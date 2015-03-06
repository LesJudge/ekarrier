<?php
class Szektor_Show_Model extends Page_Edit_Model
{
        
        public function __construct()
        {
                $this->addDB('MYSQL_DB');
                $this->__addForm();
        }
        
        public function __addForm() {
        parent::__addForm();
        $this->addItem('BtnAddComment');
        
        }
        /**
         * Lekérdezi a kompetenciát URL alapján.
         * @param string $url => Kompetencia URL.
         * @param int $lId => Nyelv azonosító.
         * @return array
         */
        public function findSzektorByID($id,$lId)
        {
                $query = "SELECT szektor_id,
                                            szektor_nev,
                                            szektor_leiras
                               FROM szektor
                               WHERE szektor_id=".(int)($id)." AND
                                            szektor_aktiv=1 AND
                                            szektor_torolt=0 AND
                                            nyelv_id=".(int)$lId."
                               LIMIT 1";
                
                return $this->_DB->prepare($query)->query_select()->query_fetch_array();
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
        
        
        public function addComment($uID, $sID, $comment){
        
            $query = "INSERT INTO szektor_hozzaszolas
                      SET ugyfel_id = ".(int)$uID.", szektor_id = ".(int)$sID.", hozzaszolas = '".mysql_real_escape_string($comment)."', bekuldes_date = NOW(),
                          szektor_hozzaszolas_aktiv = 0, szektor_hozzaszolas_torolt = 0
                     "
                        ;
        
        
            return $this->_DB->prepare($query)->query_insert();
        
    }
    
    public function findCommentsBySzektorID($id)
    {
        try{
            $query = "
                    SELECT sh.hozzaszolas AS text,
                           sh.bekuldes_date AS bekuldve,  
                            CONCAT(u.vezeteknev, ' ', u.keresztnev) AS nev
                    FROM szektor_hozzaszolas sh
                    INNER JOIN ugyfel u ON u.ugyfel_id = sh.ugyfel_id
                    WHERE sh.szektor_id = ".(int)$id."
                          AND sh.szektor_hozzaszolas_aktiv = 1
                          AND sh.szektor_hozzaszolas_torolt = 0
                          AND u.ugyfel_aktiv = 1
                          AND u.ugyfel_torolt = 0
                            "
                    ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }    
    }
        
        
}