<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData as BirthDataModel;

class BirthData
{
    /**
     *
     * @var \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData
     */
    protected $instance;
    
    public function __construct(BirthDataModel $instance)
    {
        $this->instance = $instance;
    }
    
    public function getBirthDate()
    {
        $birthdate = $this->instance->read_attribute('szuletesi_ido');
        if (is_object($birthdate)) {
            return $birthdate->format('Y-m-d');
        }
        return null;
    }
    
    public function getFullBirthplace()
    {
        $country = $this->instance->country;
        $city = $this->instance->city;
        if ($country && $city) {
            return $country->nev . ', ' . $city->cim_varos_nev;
        } else {
            if ($country) {
                return $country->nev;
            }
            if ($city) {
                return $city->cim_varos_nev;
            }
            return null;
        }
    }
    
    public function getInstance()
    {
        return $this->instance;
    }
}