<?php
namespace Uniweb\Module\Ugyfel\Library\Decorator;

use ReflectionObject;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Address as AddressModel;

class SheepItAddress
{
    /**
     * @var AddressModel
     */
    private $address;
    
    /**
     * SheepIt prefix.
     * @var string
     */
    private $prefix;
    
    public function __construct(AddressModel $address, $prefix)
    {
        $this->address = $address;
        $this->prefix = $prefix;
    }
    
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        $reflector = new ReflectionObject($this);
        if ($reflector->hasMethod($method)) {
            return $reflector->getMethod($method)->invoke($this);
        }
        $this->address->__get($name);
    }
    
    private function getError($attribute)
    {
        if (is_object($this->address->errors)) {
            return $this->address->errors->on($attribute);
        }
        return null;
    }
    
    /**
     * Visszatér az ország nevével.
     * @return array
     */
    public function getCountryName()
    {
        return array(
            $this->prefix . '_country' => $this->address->country->nev,
            $this->prefix . '_country_error' => $this->getError('cim_orszag_id')
        );
    }
    
    /**
     * Visszatér a megye nevével.
     * @return array
     */
    public function getCountyName()
    {
        return array(
            $this->prefix . '_county' => $this->address->county->cim_megye_nev,
            $this->prefix . '_county_error' => $this->getError('cim_megye_id')
        );
    }
    
    /**
     * Visszatér a város nevével.
     * @return array
     */
    public function getCityName()
    {
        return array(
            $this->prefix . '_city' => $this->address->city->cim_varos_nev,
            $this->prefix . '_city_error' => $this->getError('cim_varos_id')
        );
    }
    
    /**
     * Visszatér az irányítószámmal.
     * @return array
     */
    public function getZipCode()
    {
        return array(
            $this->prefix . '_zipcode' => $this->address->zipcode->iranyitoszam,
            $this->prefix . '_zipcode_error' => $this->getError('cim_iranyitoszam_id')
        );
    }
    
    /**
     * Visszatér a cím objektummal.
     * @return AddressModel
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Visszatér a form prefixével.
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
    
    /**
     * Beállítja a cím objektumot.
     * @param AddressModel $address
     */
    public function setAddress(AddressModel $address)
    {
        $this->address = $address;
    }
    
    /**
     * Beállítja a form prefixét.
     * @param string $prefix Form prefixe.
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }
}
