<?php
/**
 * SEO Site Model. SEO rekordokat lehet vele kigyűjteni a seo táblából.
 * @property MYSQL_DB $_DB Adatbázis.
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
class seo_Site_Model extends Model
{
    const USE_DEFAULT_LANG_ID = 0;
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
    }
    /**
     * Példányosít egy modelt.
     * @return seo_Site_Model
     */
    public static function model()
    {
        return new self;
    }
    /**
     * Eldönti, hogy a paraméterül adott, vagy a configban lévő nyelv azonosítót kell használnia.
     * @param int $langId Nyelv azonosító.
     * @return int
     */
    protected function chooseLangId($langId)
    {
        return ((int)$langId > self::USE_DEFAULT_LANG_ID) ? $langId : Rimo::$_config->SITE_NYELV_ID;
    }
    /**
     * SEO azonosító alapján lekérdezi a SEO elemet.
     * @param int $seoId SEO elem azonosító.
     * @param int $langId Nyelv azonosító.
     * @return array
     * @throws \Exception_404
     */
    public function findSeoItemById($seoId, $langId = self::USE_DEFAULT_LANG_ID)
    {
        try {
            $query = "SELECT seo_id, seo_kulcs, seo_nev, seo_leiras, seo_meta_kulcsszo
                     FROM seo 
                     WHERE seo_id=" . (int)$seoId . " AND
                           nyelv_id=" . (int)$this->chooseLangId($langId) . " AND
                           seo_aktiv=1 AND
                           seo_torolt=0
                     LIMIT 1";
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            throw new Exception_404;
        }
    }
    /**
     * SEO kulcs alapján lekérdezi a SEO elemet.
     * @param string $key SEO elem kulcsa.
     * @param int $langId Nyelv azonosító.
     * @return array
     * @throws \Exception_404
     */
    public function findSeoItemByKey($key, $langId = self::USE_DEFAULT_LANG_ID)
    {
        try {
            $query = "SELECT seo_id, seo_kulcs, seo_nev, seo_leiras, seo_meta_kulcsszo
                      FROM seo
                      WHERE seo_kulcs='" . mysql_real_escape_string($key) . "' AND
                            nyelv_id=" . (int)$this->chooseLangId($langId) . " AND
                            seo_aktiv=1 AND
                            seo_torolt=0
                      LIMIT 1";
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            throw new Exception_404;
        }
    }
    /**
     * Lekérdezi a SEO elemet ID alapján.
     * @param int $seoId => SEO azonosító
     * @param int $lId => Nyelv azonosító
     * @return mixed (false|array)
     * @deprecated
     */
    public function getSeoItemById($seoId, $lId)
    {
        try {
            $query = "SELECT seo_id,
                                                    seo_kulcs,
                                                    seo_nev,
                                                    seo_leiras,
                                                    seo_meta_kulcsszo
                                       FROM seo
                                       WHERE seo_id=" . (int) $seoId . " AND
                                                    nyelv_id=" . (int) $lId . " AND
                                                    seo_aktiv=1 AND
                                                    seo_torolt=0
                                       LIMIT 1";
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        } catch (Exception_MYSQL_Null_Rows $e) {
            return false;
        }
    }
    /**
     * Lekérdezi a SEO elemet kulcs alapján.
     * @param string $key => SEO elem kulcs
     * @param int $lId => Nyelv azonosító
     * @return mixed (false|array)
     * @deprecated
     */
    public function getSeoItemByKey($key, $lId)
    {
        try {
            $query = "SELECT seo_id,
                                       seo_kulcs,
                                       seo_nev,
                                       seo_leiras,
                                       seo_meta_kulcsszo
                                       FROM seo
                                       WHERE seo_kulcs='" . mysql_real_escape_string($key) . "' AND
                                       nyelv_id=" . (int) $lId . " AND
                                       seo_aktiv=1 AND
                                       seo_torolt=0
                                       LIMIT 1";
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();
        } catch (Exception_MYSQL_Null_Rows $e) {
            return false;
        }
    }
}
