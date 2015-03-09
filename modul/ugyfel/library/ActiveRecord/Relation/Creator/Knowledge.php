<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\CreateByData;

class Knowledge extends CreateByData
{
    public function create($data)
    {
        /* @var $knowledge \Uniweb\Module\Ugyfel\Model\ActiveRecord\Knowledge */
        $knowledge = parent::create($data);
        $knowledge->ugyfel_attr_nyelvtudas_torolt = 0;
        return $knowledge;
    }
}