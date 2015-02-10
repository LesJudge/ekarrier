<?php

class AddressFinder extends \DbInjectAbstract
{
    const DEFAULT_COUNTRY_ID = 124;

    public function findCountries()
    {
        try {
            $query = "SELECT country_id, country_name FROM cim_view GROUP BY country_id";
            $result = $this->db->prepare($query)->query_select();
            $countries = array();
            while ($data = $result->query_fetch_array()) {
                $countries[$data['country_id']] = $data['country_name'];
            }
            return $countries;
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }

    public function findCountiesByCountryId($countryId = self::DEFAULT_COUNTRY_ID)
    {
        if ((int) $countryId === 0) {
            $countryId = self::DEFAULT_COUNTRY_ID;
        }
        try {
            $query = "SELECT county_id, county_name FROM cim_view WHERE country_id = " . $countryId;
            $result = $this->db->prepare($query)->query_select();
            $counties = array();
            while ($data = $result->query_fetch_array()) {
                $counties[$data['county_id']] = $data['county_name'];
            }
            return $counties;
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }

    public function findCitiesByCountryId($countryId = self::DEFAULT_COUNTRY_ID)
    {
        if ((int) $countryId === 0) {
            $countryId = self::DEFAULT_COUNTRY_ID;
        }
        try {
            $query = "SELECT city_id, city_name FROM cim_view WHERE country_id = " . $countryId;
            $result = $this->db->prepare($query)->query_select();
            $counties = array();
            while ($data = $result->query_fetch_array()) {
                $counties[$data['city_id']] = $data['city_name'];
            }
            return $counties;
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }

    public function findZipCodesByCountryId($countryId = self::DEFAULT_COUNTRY_ID)
    {
        if ((int) $countryId === 0) {
            $countryId = self::DEFAULT_COUNTRY_ID;
        }
        try {
            $query = "SELECT zip_code_id, zip_code FROM cim_view WHERE country_id = " . $countryId;
            $result = $this->db->prepare($query)->query_select();
            $counties = array();
            while ($data = $result->query_fetch_array()) {
                $counties[$data['zip_code_id']] = $data['zip_code'];
            }
            return $counties;
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
}
