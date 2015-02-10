<?php
class Ceg_Ajax_Model extends Model
{
        
        public function __construct()
        {
                $this->addDB('MYSQL_DB');
        }
        
        /**
         * Lekérdezi a munkakörhöz tartozó kompetenciákat.
         * @param int $jobId => Munkakör azonosító.
         * @param int $lId => Nyelv ID.
         * @return mixed (false|array)
         */
        public function getCompetenciesByJobId($jobId,$lId)
        {
                try
                {
                        $query="SELECT mk.kompetencia_id
                                       FROM munkakor m
                                       INNER JOIN munkakor_kompetencia mk ON mk.munkakor_id=m.munkakor_id
                                       WHERE m.munkakor_id=".(int)$jobId." AND
                                                    m.nyelv_id=".(int)$lId;
                        return $this->_DB->prepare($query)->query_select()->query_result_array();
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return false;
                }
        }
        
}