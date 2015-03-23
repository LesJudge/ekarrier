<?php
class Pozicioteszt_Pozicio_Show_Model extends Page_Edit_Model
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
        
        public function findPozicioByLink($link)
        {
                $query = "SELECT pozicio_id,
                                            pozicio_nev,
                                            pozicio_leiras
                               FROM pozicio
                               WHERE link = '".mysql_real_escape_string($link)."' AND
                                            pozicio_aktiv=1 AND
                                            pozicio_torolt=0
                               LIMIT 1";
                
                return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        }
        
        /*
        public function updateViews($compId,$lId)
        {
                $query="UPDATE kompetencia
                               SET kompetencia_megtekintve=kompetencia_megtekintve+1
                               WHERE kompetencia_id=".(int)$compId." AND
                               nyelv_id=".(int)$lId."
                               LIMIT 1";
                $this->_DB->prepare($query)->query_execute();
        }
        */
        
        public function addComment($uID, $pID, $comment){
        
            $query = "INSERT INTO pozicio_hozzaszolas
                      SET ugyfel_id = ".(int)$uID.", pozicio_id = ".(int)$pID.", hozzaszolas = '".mysql_real_escape_string($comment)."', bekuldes_date = NOW(),
                          pozicio_hozzaszolas_aktiv = 0, pozicio_hozzaszolas_torolt = 0
                     "
                        ;
        
        
            return $this->_DB->prepare($query)->query_insert();
        
    }
    
    public function findCommentsByPozicioID($id)
    {
        try{
            $query = "
                    SELECT ph.hozzaszolas AS text,
                           ph.bekuldes_date AS bekuldve,  
                            CONCAT(u.vezeteknev, ' ', u.keresztnev) AS nev
                    FROM pozicio_hozzaszolas ph
                    INNER JOIN ugyfel u ON u.ugyfel_id = ph.ugyfel_id
                    WHERE ph.pozicio_id = ".(int)$id."
                          AND ph.pozicio_hozzaszolas_aktiv = 1
                          AND ph.pozicio_hozzaszolas_torolt = 0
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