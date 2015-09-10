<?php
namespace Uniweb\Module\Ugyfel\Library\Facade\Form;

use ArrayObject;
use Uniweb\Library\Form\Interfaces\AssignableInterface;
use Uniweb\Module\Ugyfel\Library\Form\Edit\MapProgramInformations;
use Uniweb\Module\Ugyfel\Library\Form\Edit\MapServices;
use Uniweb\Module\Ugyfel\Library\Form\Edit\MapWorkSchedules;

class SelectedFacade implements AssignableInterface
{
    public function assign(ArrayObject $data)
    {
        $mapProgramInformations = new MapProgramInformations(
            $data->offsetGet('beallitasProgramInformation'), $data->offsetGet('client')->programinformations
        );
        $mapWorkSchedules = new MapWorkSchedules(
            $data->offsetGet('beallitasWorkSchedule'), $data->offsetGet('client')->workschedules
        );
        $mapServices = new MapServices($data->offsetGet('szolgaltatasServices'), $data->offsetGet('client')->services);
        $data->offsetSet('programInformations', $mapProgramInformations->map());
        $data->offsetSet('workschedules', $mapWorkSchedules->map());
        $data->offsetSet('services', $mapServices->map());
    }
}