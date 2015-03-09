<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class Workschedule implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        /* @var $workschedules \Uniweb\Module\Ugyfel\Model\ActiveRecord\WorkSchedule */
        $workschedules = $client->workschedules;
        $data = array();
        if (is_array($workschedules) && !empty($workschedules)) {
            foreach ($workschedules as $workschedule) {
                $data[] = $workschedule->workschedule->nev;
            }
        }
        return $data;
    }
}