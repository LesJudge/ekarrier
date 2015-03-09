<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\Address;
use Uniweb\Module\Ugyfel\Library\Xls\Reader\Address\AddressAbstract;

class City extends AddressAbstract
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        $residence = $this->getResidenceByClient($client);
        if (is_object($residence)) {
            return $residence->varos;
        }
        return '';
    }
}