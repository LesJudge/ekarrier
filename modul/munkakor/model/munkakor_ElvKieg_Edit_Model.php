<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class Munkakor_ElvKieg_Edit_Model extends Munkakor_TartKieg_Edit_Model
{
        
        public $_tableName='munkakor_elvarasok_kiegeszites';
        
        /**
         * Lekérdezi az aktuális munka adatait.
         * @param int $rowId => Rekord azonosító
         * @param int $lId => Nyelv azonosító
         * @return array
         */
        protected function getActualJobData($rowId,$lId)
        {

                $query="SELECT m.munkakor_id,
                                            m.munkakor_nev,
                                            m.munkakor_elvarasok AS tartalom
                               FROM munkakor_elvarasok_kiegeszites mek
                               INNER JOIN munkakor m ON m.munkakor_id=mek.munkakor_id AND m.nyelv_id=mek.nyelv_id
                               WHERE mek.munkakor_elvarasok_kiegeszites_id=".(int)$rowId." AND
                                            mek.nyelv_id=".(int)$lId."
                               LIMIT 1";
                return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        }
        
        /**
         * Menti a tartalmat.
         * @param int $jobId => Munkakör azonosító
         * @param int $lId => Nyelv azonosító
         */
        protected function saveContent2Job($jobId,$lId)
        {
                $query="UPDATE munkakor SET munkakor_elvarasok='".mysql_real_escape_string($this->getItemValue('TxtAktTartalom'))."'
                               WHERE munkakor_id=".(int)$jobId." AND
                                            nyelv_id=".(int)$lId."
                               LIMIT 1";
                $this->_DB->prepare($query)->query_update();
        }
        
}