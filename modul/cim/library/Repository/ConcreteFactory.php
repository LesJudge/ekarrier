<?php
namespace Uniweb\Module\Cim\Library\Repository;
use Uniweb\Module\Cim\Library\AddressFinderInteface;
use InvalidArgumentException;

class ConcreteFactory
{
    protected $types = array();
    
    public function __construct()
    {
        $this->types = array(
            'country' => __NAMESPACE__ . '\\CountryRepository',
            'countries' => __NAMESPACE__ . '\\CountryRepository',
            'county' => __NAMESPACE__ . '\\CountyRepository',
            'counties' => __NAMESPACE__ . '\\CountyRepository',
            'city' => __NAMESPACE__ . '\\CityRepository',
            'cities' => __NAMESPACE__ . '\\CityRepository',
            'zipcode' => __NAMESPACE__ . '\\ZipCodeRepository',
            'zipcodes' => __NAMESPACE__ . '\\ZipCodeRepository'
        );
    }
    
    public function create($type, AddressFinderInteface $finder)
    {
        if (!array_key_exists($type, $this->types)) {
            throw new InvalidArgumentException('Nem megfelelő típus!');
        }
        return new $this->types[$type]($finder);
    }
}