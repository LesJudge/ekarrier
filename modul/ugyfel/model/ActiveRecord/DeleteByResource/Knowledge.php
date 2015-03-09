<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Knowledge as KnowledgeModel;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;

class Knowledge implements DeletableByResourceInterface
{
    public function deleteByResource(\Uniweb\Library\Resource\Interfaces\ResourceInterface $resource)
    {
        KnowledgeModel::update_all(array(
            'conditions' => array(
                KnowledgeModel::getResourceKey() => $resource->getResourceId()
            ),
            'set' => array(
                'modositas_timestamp' => date('Y-m-d H:i:s'),
                'ugyfel_attr_nyelvtudas_torolt' => 1
            )
        ));
    }
}