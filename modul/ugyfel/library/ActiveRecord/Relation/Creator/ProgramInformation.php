<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\CreateByData;

class ProgramInformation extends CreateByData
{
    public function create($data)
    {
        /* @var $programInformation \Uniweb\Module\Ugyfel\Model\ActiveRecord\ProgramInformation */
        $programInformation = parent::create($data);
        $programInformation->ugyfel_attr_program_informacio_torolt = 0;
        return $programInformation;
    }
}