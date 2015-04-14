<?php
/**
 * @property MYSQL_DB $_DB Database.
 */
class User_cim_Ajax_Model extends AjaxModel
{
    const CACHE_KEY_ADDRESS_CITY = 'addressCity';
    const CACHE_KEY_ADDRESS_CITIES = 'addressCities';
    const CACHE_KEY_ADDRESS_ZIPCODE = 'zipCode';
    
    public function findAndCacheAllCities()
    {
        return $this->theResult(self::CACHE_KEY_ADDRESS_CITIES, self::CACHE_MAX_AGE, function($model) {
            $query = "SELECT *, city_name AS label, city_id AS value FROM cim_view";
            return $model->_DB->prepare($query)->query_select()->query_result_array();
        });
    }
    
    public function findAndCacheZipCodes()
    {
        return $this->theResult(static::CACHE_KEY_ADDRESS_CITIES, static::CACHE_MAX_AGE, function($model) {
            $query = "SELECT *, zip_code AS label, zip_code_id AS value FROM cim_view";
            return $model->_DB->prepare($query)->query_select()->query_result_array();
        });
    }
    /**
     * Irányítószám alapján keres az irányítószámok között.
     * @param string $zipCode Irányítószám
     * @return array
     */
    public function findByZipCode($zipCode)
    {
        $query = "SELECT *, zip_code AS label, zip_code_id AS value 
            FROM cim_view WHERE zip_code LIKE '" . mysql_real_escape_string($zipCode) . "%'";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    /**
     * Város név alapján keres a városok között.
     * @param string $city Város neve.
     * @return array
     */
    public function findByCity($city)
    {
        $query = "SELECT *, city_name AS label, city_id AS value 
            FROM cim_view WHERE city_name LIKE '" . mysql_real_escape_string($city) . "%'";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function findByCounty($county)
    {
        $query = "SELECT county_id, county_name, county_name AS label, county_id AS value 
            FROM cim_view WHERE county_name LIKE '" . mysql_real_escape_string($county) . "%' GROUP BY county_id";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    /**
     * Város azonosító alapján lekérdezi a település adatait.
     * @param int $cityId Város azonosító.
     * @return array
     */
    public function findByCityId($cityId)
    {
        $query = "SELECT * FROM cim_view WHERE city_id = " . $cityId . " LIMIT 1";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    /**
     * Város azonosító alapján lekérdezi és cache-eli a település adatait.
     * @param int $cityId Város azonosító.
     * @return array
     */
    public function findAndCacheByCityId($cityId)
    {
        $cityId = (int)$cityId;
        $key = self::CACHE_KEY_ADDRESS_CITY . $cityId;
        return $this->theResult($key, self::CACHE_MAX_AGE, function($model) use ($cityId) {
            return $model->findByCityId($cityId);
        });
    }
}