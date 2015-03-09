<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\ProgramInformation as ProgramInformationModel;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;

class ProgramInformation implements DeletableByResourceInterface
{
    public function deleteByResource(\Uniweb\Library\Resource\Interfaces\ResourceInterface $resource)
    {
        ProgramInformationModel::update_all(array(
            'conditions' => array(
                ProgramInformationModel::getResourceKey() => $resource->getResourceId()
            ),
            'set' => array(
                'modositas_timestamp' => date('Y-m-d H:i:s'),
                'ugyfel_attr_program_informacio_torolt' => 1
            )
        ));
    }
}
