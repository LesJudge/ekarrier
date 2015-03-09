<?php
namespace Uniweb\Module\Cim\Library\Repository;
use Uniweb\Module\Cim\Library\Repository\AbstractAddressRepository;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCountryInterface;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCountyInterface;
use Uniweb\Module\Cim\Library\Interfaces\FindableByZipCodeInterface;
use Uniweb\Library\Interfaces\FindableByName;

class CityRepository extends AbstractAddressRepository 
implements FindableByCountryInterface, FindableByCountyInterface, FindableByZipCodeInterface, FindableByName
{
    protected $fields = array(
        'city_id', 
        'city_name', 
        'county_id', 
        'county_name', 
        'country_id',
        'country_name',
        'country_code',
        'zip_code_id',
        'zip_code'
    );
    
    public function findAll()
    {
        return $this->finder->findAddress($this->fields);
    }

    public function findById($id)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('city_id' => $id)));
    }

    public function findByName($name)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('city_name' => $name)));
    }
    
    public function findByCountryId($countryId)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array('country_id' => $countryId),
            'group' => 'city_id'
        ));
    }
    
    public function findByCountryName($countryName)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('country_name' => $countryName)));
    }
    
    public function findByCountyId($countyId)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('county_id' => $countyId)));
    }
    
    public function findByCountyName($countyName)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('county_name' => $countyName)));
    }
    
    public function findByZipCodeId($zipCodeId)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('zip_code_id' => $zipCodeId)));
    }
    
    public function findByZipCode($zipCode)
    {
        return $this->finder->findAddress($this->fields, array('conditions' => array('zip_code' => $zipCode)));
    }
}