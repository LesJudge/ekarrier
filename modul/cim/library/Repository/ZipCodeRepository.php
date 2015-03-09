<?php
namespace Uniweb\Module\Cim\Library\Repository;
use Uniweb\Module\Cim\Library\Repository\AbstractAddressRepository;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCityInterface;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCountryInterface;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCountyInterface;

class ZipCodeRepository extends AbstractAddressRepository implements 
FindableByCityInterface, FindableByCountryInterface, FindableByCountyInterface
{
    protected $fields = array(
        'country_id', 
        'country_name', 
        'country_code', 
        'zip_code_id', 
        'zip_code',
        'city_id', 
        'city_name', 
        'county_id', 
        'county_name'
    );
    
    public function findAll()
    {
        return $this->finder->findAddress($this->fields);
    }

    public function findById($id)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('zip_code_id' => $id)));
    }

    public function findByCityId($cityId)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('city_id' => $cityId)));
    }

    public function findByCityName($cityName)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('city_name' => $cityName)));
    }

    public function findByCountyId($countyId)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('county_id' => $countyId)));
    }

    public function findByCountyName($countyName)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('county_name' => $countyName)));
    }
    
    public function findByCountryId($countryId)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('country_id' => $countryId)));
    }

    public function findByCountryName($countryName)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('country_name' => $countryName)));
    }
}