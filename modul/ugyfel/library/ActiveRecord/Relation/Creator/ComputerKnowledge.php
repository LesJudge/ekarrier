<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\CreateByData;

class ComputerKnowledge extends CreateByData
{
    public function create($data)
    {
        /* @var $computerKnowledge \Uniweb\Module\Ugyfel\Model\ActiveRecord\ComputerKnowledge */
        $computerKnowledge = parent::create($data);
        $computerKnowledge->ugyfel_attr_szamitogepes_ismeret_torolt = 0;
        return $computerKnowledge;
    }
}