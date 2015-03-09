<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\CreateByData;

class Job extends CreateByData
{
    public function create($data)
    {
        /* @var $job \Uniweb\Module\Ugyfel\Model\ActiveRecord\Job */
        $job = parent::create($data);
        $job->ugyfel_attr_munkakor_torolt = 0;
        return $job;
    }
}