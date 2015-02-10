<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class sugo_Site_Model extends Model
{
        
        public function __construct()
        {
                $this->addDB('MYSQL_DB');
        }
        
        /**
         * Visszatér a súgó nevével és a tartalmával.
         * @param int $id => A súgó azonosítója.
         * @return mixed (false|array)
         */
        public function getSugoById($id)
        {
                try
                {
                        $query="SELECT sugo_nev,
                                                    sugo_tartalom
                                       FROM sugo
                                       WHERE sugo_id=".(int)$id." AND
                                                    nyelv_id=".Rimo::$_config->SITE_NYELV_ID." AND
                                                    sugo_aktiv=1 AND
                                                    sugo_torolt=0
                                       LIMIT 1";
                        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return false;
                }
        }
        
        /**
         * Véletlenszerűen kiválaszt súgó elemeket.
         * @param int $limit => Ennyi rekordra limitáljon.
         * @return mixed (false|array)
         */
        public function getRandomSugo($limit)
        {
                try
                {
                        $query="SELECT sugo_id,
                                                    sugo_nev,
                                                    sugo_tartalom 
                                       FROM sugo 
                                       WHERE sugo_id >= (SELECT FLOOR(MAX(sugo_id) * RAND()) FROM sugo ) AND
                                                    sugo_aktiv=1 AND
                                                    sugo_torolt=0
                                       ORDER BY sugo_id
                                       LIMIT ".(int)$limit;
                        return $this->_DB->prepare($query)->query_select()->query_result_array();
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return false;
                }
        }
        
}