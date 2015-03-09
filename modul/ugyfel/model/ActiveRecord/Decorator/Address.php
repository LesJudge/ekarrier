<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Address as AddressModel;

class Address
{
    protected $address;
    
    public function __construct(AddressModel $address)
    {
        $this->address = $address;
    }
    
    public function getFullAddress()
    {
        $address = '';
        if ($this->address->orszag) {
            $address .= $this->address->orszag . ', ';
        }
        if ($this->address->iranyitoszam) {
            $address .= $this->address->iranyitoszam . ', ';
        }
        $address .= $this->address->varos . ' ' . $this->address->utca . ' ' . $this->address->hazszam;
        return $address;
    }
    
    public function getAddress()
    {
        return $this->address;
    }
    
    public function setAddress(AddressModel $address)
    {
        $this->address = $address;
    }
}