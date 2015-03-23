<?php
class Kompetencia_Show_Model extends Page_Edit_Model
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
        public function findCompetenceByUrl($url,$lId)
        {
                $query="SELECT kompetencia_id,
                                            nyelv_id,
                                            kompetencia_nev,
                                            kompetencia_link,
                                            kompetencia_leiras,
                                            kompetencia_meta_kulcsszo,
                                            kompetencia_tartalom,
                                            kompetencia_create_date,
                                            kompetencia_modositas_datum
                               FROM kompetencia
                               WHERE kompetencia_link='".mysql_real_escape_string($url)."' AND
                                            kompetencia_aktiv=1 AND
                                            kompetencia_torolt=0 AND
                                            tipus = 'sajat' AND
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
        
        
        public function addComment($uID, $kID, $comment){
        
            $query = "INSERT INTO kompetencia_hozzaszolas
                      SET ugyfel_id = ".(int)$uID.", kompetencia_id = ".(int)$kID.", hozzaszolas = '".mysql_real_escape_string($comment)."', bekuldes_date = NOW(),
                          kompetencia_hozzaszolas_aktiv = 0, kompetencia_hozzaszolas_torolt = 0, checked = 0
                     "
                        ;
        
        
            return $this->_DB->prepare($query)->query_insert();
        
    }
    
    public function findCommentsByCompetenceID($id)
    {
        try{
            $query = "
                    SELECT kh.hozzaszolas AS text,
                           kh.bekuldes_date AS bekuldve,  
                            CONCAT(u.vezeteknev, ' ', u.keresztnev) AS nev
                    FROM kompetencia_hozzaszolas kh
                    INNER JOIN ugyfel u ON u.ugyfel_id = kh.ugyfel_id
                    WHERE kh.kompetencia_id = ".(int)$id."
                          AND kh.kompetencia_hozzaszolas_aktiv = 1
                          AND kh.kompetencia_hozzaszolas_torolt = 0
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