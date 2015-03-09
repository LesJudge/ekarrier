<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\CreateByData;

class Address extends CreateByData
{
    public function create($data)
    {
        /* @var $address \Uniweb\Module\Ugyfel\Model\ActiveRecord\Address */
        $address = parent::create($data);
        $address->ugyfel_attr_cim_torolt = 0;
        return $address;
    }
}