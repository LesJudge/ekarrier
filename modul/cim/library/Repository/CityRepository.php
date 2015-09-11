<?php
namespace Uniweb\Module\Cim\Library\Repository;

use Uniweb\Library\Interfaces\FindableByName;
use Uniweb\Module\Cim\Library\AddressRepositoryInterface;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCountryInterface;
use Uniweb\Module\Cim\Model\ActiveRecord\City;

class CityRepository implements AddressRepositoryInterface, FindableByCountryInterface, FindableByName
{
    public function findAll()
    {
        $cities = City::all(array(
            'conditions' => array(
                'cim_varos_torolt' => 0
            )
        ));
        
        return $this->toArray($cities);
    }

    public function findById($id)
    {
        $cities = City::all(array(
            'conditions' => array(
                'cim_varos_id' => $id
            )
        ));
        
        return $this->toArray($cities);
    }

    public function findByName($name)
    {
        $cities = City::all(array(
            'conditions' => array(
                'city_name' => $name
            )
        ));
        
        return $this->toArray($cities);
    }
    
    public function findByCountryId($countryId)
    {
        $cities = City::all(array(
            'conditions' => array(
                'cim_orszag_id' => $countryId
            )
        ));
        
        return $this->toArray($cities);
    }
    
    public function findByCountryName($countryName)
    {
        return array();
    }
    
    private function toArray($cities)
    {
        $result = array();
        
        foreach ($cities as $city) {
            $result[$city->id] = array(
                'city_id' => $city->id,
                'city_name' => $city->cim_varos_nev
            );
        }
        
        return $result;
    }
}