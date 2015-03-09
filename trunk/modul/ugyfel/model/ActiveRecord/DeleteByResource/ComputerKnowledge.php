<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\ComputerKnowledge as ComputerKnowledgeModel;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;

class ComputerKnowledge implements DeletableByResourceInterface
{
    public function deleteByResource(\Uniweb\Library\Resource\Interfaces\ResourceInterface $resource)
    {
        ComputerKnowledgeModel::update_all(array(
            'conditions' => array(
                ComputerKnowledgeModel::getResourceKey() => $resource->getResourceId()
            ),
            'set' => array(
                'modositas_timestamp' => date('Y-m-d H:i:s'),
                'ugyfel_attr_szamitogepes_ismeret_torolt' => 1
            )
        ));
    }
}