<?php
namespace Uniweb\Module\Cim\Library\Repository;
use Uniweb\Module\Cim\Library\Repository\AbstractAddressRepository;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCityInterface;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCountryInterface;
use Uniweb\Module\Cim\Library\Interfaces\FindableByZipCodeInterface;
use Uniweb\Library\Interfaces\FindableByName;

class CountyRepository extends AbstractAddressRepository implements 
FindableByCityInterface, FindableByCountryInterface, FindableByZipCodeInterface, FindableByName
{
    protected $fields = array('county_id', 'county_name', 'country_id', 'country_name', 'country_code');
    
    public function findAll()
    {
        return $this->finder->findAddress($this->fields, array('group' => 'county_id'));
    }

    public function findById($id)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array('county_id' => $id),
            'group' => 'county_id'
        ));
    }

    public function findByName($name)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array('country_name' => $name),
            'group' => 'county_id'
        ));
    }
    
    public function findByCountryId($countryId)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array('country_id' => $countryId),
            'group' => 'county_id'
        ));
    }
    
    public function findByCountryName($countryName)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array('country_name' => $countryName),
            'group' => 'county_id'
        ));
    }
    
    public function findByZipCodeId($zipCodeId)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array('zip_code_id' => $zipCodeId)
        ));
    }
    
    public function findByZipCode($zipCode)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array('zip_code' => $zipCode)
        ));
    }
    
    public function findByCityId($cityId)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array('city_id' => $cityId)
        ));
    }
    
    public function findByCityName($cityName)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array('city_name' => $cityName)
        ));
    }
}