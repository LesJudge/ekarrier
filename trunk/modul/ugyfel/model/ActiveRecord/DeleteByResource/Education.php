<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Education as EducationModel;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;

class Education implements DeletableByResourceInterface
{
    public function deleteByResource(\Uniweb\Library\Resource\Interfaces\ResourceInterface $resource)
    {
        EducationModel::update_all(array(
            'conditions' => array(
                EducationModel::getResourceKey() => $resource->getResourceId()
            ),
            'set' => array(
                'modositas_timestamp' => date('Y-m-d H:i:s'),
                'ugyfel_attr_vegzettseg_torolt' => 1
            )
        ));
    }
}