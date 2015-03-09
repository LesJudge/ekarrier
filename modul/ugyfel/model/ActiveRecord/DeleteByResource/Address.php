<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Address as AddressModel;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;

class Address implements DeletableByResourceInterface
{
    public function deleteByResource(\Uniweb\Library\Resource\Interfaces\ResourceInterface $resource)
    {
        AddressModel::update_all(array(
            'conditions' => array(
                AddressModel::getResourceKey() => $resource->getResourceId()
            ),
            'set' => array(
                'modositas_timestamp' => date('Y-m-d H:i:s'),
                'ugyfel_attr_cim_torolt' => 1
            )
        ));
    }
}