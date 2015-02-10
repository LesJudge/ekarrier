<?php
class hir_ShowBox_List_Model extends Model
{

        public function __construct()
        {
                $this->addDB("MYSQL_DB");
        }

        public function getHirList($limit,$categoryId=1,$ma=0)
        {
                try
                {
                        $query="SELECT hir_cim,
                                                    hir_link,
                                                    hir_kep_nev,
                                                    hir_leiras,
                                                    DATE_FORMAT(hir_megjelenes,'%Y-%m-%d %H:%i') AS megjelenes,
                                                    IF(LENGTH(hir_leiras)>100, CONCAT(SUBSTR(hir_leiras,1,100),'...'),hir_leiras) AS hir_leiras_min
                                       FROM hir 
                                       INNER JOIN hir_attr_kategoria ON hir.hir_id=hir_attr_kategoria.hir_id
                                       INNER JOIN hir_kategoria ON hir_kategoria_id=hir_attr_kategoria_id
                                       WHERE hir.nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND 
                                                    hir_kategoria.nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND 
                                                    hir_aktiv=1 AND 
                                                    hir_torolt=0 AND 
                                                    hir_kategoria_aktiv=1 AND 
                                                    hir_kategoria_torolt=0 AND 
                                                    hir_kategoria_id=".(int)$categoryId." AND
                                                    (
                                                        (NOW() BETWEEN hir_megjelenes AND hir_lejarat)  OR
                                                        (hir_megjelenes<NOW() AND hir_lejarat='0000-00-00 00:00:00')
                                                    ) AND kategoria_ma=".$ma."
                                       GROUP BY hir.hir_id 
                                       ORDER BY hir_megjelenes DESC 
                                       LIMIT ".(int)$limit;
                        return $this->_DB->prepare($query)->query_select()->query_result_array();
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        
                }
        }

}