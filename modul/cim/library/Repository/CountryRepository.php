<?php
namespace Uniweb\Module\Cim\Library\Repository;

use Uniweb\Library\Interfaces\FindableByName;
use Uniweb\Module\Cim\Library\AddressRepositoryInterface;
use Uniweb\Module\Cim\Model\ActiveRecord\Country;

class CountryRepository implements AddressRepositoryInterface, FindableByName
{
    /**
     * Lekérdezi az összes országot.
     * @return array
     */
    public function findAll()
    {
        $countries = Country::all(array(
            'conditions' => array(
                'cim_orszag_torolt' => 0
            )
        ));
        
        return $this->toArray($countries);
    }
    
    /**
     * Lekérdezi az országot azonosító alapján.
     * @param int $id Ország azonosító.
     * @return array
     */
    public function findById($id)
    {
        $countries = Country::all(array(
            'conditions' => array(
                'cim_orszag_id' => $id
            )
        ));
        
        return $this->toArray($countries);
    }
    
    /**
     * Lekérdezi az országot név alapján.
     * @param string $name Ország neve.
     * @return array
     */
    public function findByName($name)
    {
        $countries = Country::all(array(
            'conditions' => array(
                'nev' => $name
            )
        ));
        
        return $this->toArray($countries);
    }
    
    private function toArray(array $countries)
    {
        $result = array();
        
        foreach ($countries as $country) {
            $result[$country->id] = array(
                'country_id' => $country->id,
                'country_name' => $country->nev
            );
        }
        
        return $result;
    }
}