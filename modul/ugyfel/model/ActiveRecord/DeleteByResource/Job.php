<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Job as JobModel;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;

class Job implements DeletableByResourceInterface
{
    public function deleteByResource(\Uniweb\Library\Resource\Interfaces\ResourceInterface $resource)
    {
        JobModel::update_all(array(
            'conditions' => array(
                JobModel::getResourceKey() => $resource->getResourceId()
            ),
            'set' => array(
                'modositas_timestamp' => date('Y-m-d H:i:s'),
                'ugyfel_attr_munkakor_torolt' => 1
            )
        ));
    }
}