<?php
class Kompetencia_Show_Model extends Model
{
        
        public function __construct()
        {
                $this->addDB('MYSQL_DB');
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
        
}