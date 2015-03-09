<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\WorkSchedule as WorkScheduleModel;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;

class WorkSchedule implements DeletableByResourceInterface
{
    public function deleteByResource(\Uniweb\Library\Resource\Interfaces\ResourceInterface $resource)
    {
        WorkScheduleModel::update_all(array(
            'conditions' => array(
                WorkScheduleModel::getResourceKey() => $resource->getResourceId()
            ),
            'set' => array(
                'modositas_timestamp' => date('Y-m-d H:i:s'),
                'ugyfel_attr_munkarend_torolt' => 1
            )
        ));
    }
}