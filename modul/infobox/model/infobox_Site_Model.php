<?php
/**
 * SEO Site Model. SEO rekordokat lehet vele kigyűjteni a infobox táblából.
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class infobox_Site_Model extends Model
{
        
        public function __construct()
        {
                $this->addDB('MYSQL_DB');
        }
        
        /**
         * Példányosít egy modelt.
         * @return infobox_Site_Model
         */
        public static function model()
        {
                return new self;
        }
        
        /**
         * Lekérdezi az infobox elemet ID alapján.
         * @param int $infoboxId => SEO azonosító
         * @param int $lId => Nyelv azonosító
         * @return mixed (false|array)
         */
        public function findInfoboxItemById($infoboxId,$lId)
        {
                try
                {
                        $query="SELECT infobox_id,
                                                    infobox_kulcs,
                                                    infobox_nev,
                                                    infobox_tartalom
                                       FROM infobox
                                       WHERE infobox_id=".(int)$infoboxId." AND
                                                    nyelv_id=".(int)$lId." AND
                                                    infobox_aktiv=1 AND
                                                    infobox_torolt=0
                                       LIMIT 1";
                        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return false;
                }
        }
        
        /**
         * Lekérdezi az infobox elemet kulcs alapján.
         * @param string $key => SEO elem kulcs
         * @param int $lId => Nyelv azonosító
         * @return mixed (false|array)
         */
        public function findInfoboxItemByKey($key,$lId)
        {
                try
                {
                        $query="SELECT infobox_id,
                                       infobox_kulcs,
                                       infobox_nev,
                                       infobox_tartalom
                                       FROM infobox
                                       WHERE infobox_kulcs='".mysql_real_escape_string($key)."' AND
                                                    nyelv_id=".(int)$lId." AND
                                                    infobox_aktiv=1 AND
                                                    infobox_torolt=0
                                       LIMIT 1";
                        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
                }
                catch(Exception_MYSQL_Null_Rows $e)
                {
                        return false;
                }
        }
        
}