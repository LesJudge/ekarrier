<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\CreateByData;

class WorkSchedule extends CreateByData
{
    public function create($data)
    {
        /* @var $workschedule \Uniweb\Module\Ugyfel\Model\ActiveRecord\WorkSchedule */
        $workschedule = parent::create($data);
        $workschedule->ugyfel_attr_munkarend_torolt = 0;
        return $workschedule;
    }
}