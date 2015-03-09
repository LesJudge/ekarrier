<?php
namespace Uniweb\Module\Cim\Library\Repository;
use Uniweb\Module\Cim\Library\Repository\AbstractAddressRepository;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCityInterface;
use Uniweb\Module\Cim\Library\Interfaces\FindableByCountyInterface;
use Uniweb\Module\Cim\Library\Interfaces\FindableByZipCodeInterface;
use Uniweb\Library\Interfaces\FindableByName;
/**
 * @property \ActiveRecord\Model $finder Finder.
 */
class CountryRepository extends AbstractAddressRepository implements 
FindableByCityInterface, FindableByCountyInterface, FindableByZipCodeInterface, FindableByName
{
    protected $fields = array('country_id', 'country_name', 'country_code');
    /**
     * Lekérdezi az összes országot.
     * @return array
     */
    public function findAll()
    {
        return $this->finder->findAddress($this->fields, array('group' => 'country_id'));
    }
    /**
     * Lekérdezi az országot azonosító alapján.
     * @param int $id Ország azonosító.
     * @return array
     */
    public function findById($id)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array(
                'country_id' => $id
            ),
            'group' => 'country_id'
        ));
    }
    /**
     * Lekérdezi az országot név alapján.
     * @param string $name Ország neve.
     * @return array
     */
    public function findByName($name)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array(
                'country_name' => $name
            ),
            'group' => 'country_id'
        ));
    }
    /**
     * Lekérdezi az országot irányítószám azonosító alapján.
     * @param int $zipCodeId Irányítószám azonosító.
     * @return array
     */
    public function findByZipCodeId($zipCodeId)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array(
                'zip_code_id' => $zipCodeId
            ),
            'group' => 'country_id'
        ));
    }
    /**
     * Lekérdezi az országot irányítószám alapján.
     * @param int $zipCode Irányítószám.
     * @return array
     */
    public function findByZipCode($zipCode)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array(
                'zip_code' => $zipCode
            ),
            'group' => 'country_id'
        ));
    }
    /**
     * Lekérdezi az országot megye azonosító alapján.
     * @param int $countyId Megye azonosító.
     * @return array
     */
    public function findByCountyId($countyId)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array(
                'county_id' => $countyId
            ),
            'group' => 'country_id'
        ));
    }
    /**
     * Lekérdezi az országot a megye neve alapján.
     * @param string $countyName Megye neve.
     * @return array
     */
    public function findByCountyName($countyName)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array(
                'county_name' => $countyName
            ),
            'group' => 'country_id'
        ));
    }
    /**
     * Lekérdezi az országot a város azonosító alapján.
     * @param int $cityId Város azonosító.
     * @return array
     */
    public function findByCityId($cityId)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array(
                'city_id' => $cityId
            ),
            'group' => 'country_id'
        ));
    }
    /**
     * Lekérdezi az országot a város neve alapján.
     * @param string $cityName Város neve.
     * @return array
     */
    public function findByCityName($cityName)
    {
        return $this->finder->findAddress($this->fields, array(
            'conditions' => array(
                'city_name' => $cityName
            ),
            'group' => 'country_id'
        ));
    }
    
    
}