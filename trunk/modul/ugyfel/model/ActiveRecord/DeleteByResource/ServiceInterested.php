<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\ServiceInterested as ServiceInterestedModel;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;

class ServiceInterested implements DeletableByResourceInterface
{
    public function deleteByResource(\Uniweb\Library\Resource\Interfaces\ResourceInterface $resource)
    {
        ServiceInterestedModel::update_all(array(
            'conditions' => array(
                ServiceInterestedModel::getResourceKey() => $resource->getResourceId()
            ),
            'set' => array(
                'modositas_timestamp' => date('Y-m-d H:i:s'),
                'ugyfel_attr_szolgaltatas_erdekelt_torolt' => 1
            )
        ));
    }
}