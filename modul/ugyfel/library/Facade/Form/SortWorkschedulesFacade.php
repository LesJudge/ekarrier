<?php
namespace Uniweb\Module\Ugyfel\Library\Facade\Form;

use ArrayObject;
use Uniweb\Library\Form\Interfaces\AssignableInterface;

/**
 * Description of SortWorkschedulesFacade
 *
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class SortWorkschedulesFacade implements AssignableInterface
{
    public function assign(ArrayObject $data)
    {
        // Megvizsgálja, hogy a nézet megkapta-e már a munkarendeket.
        if ($data->offsetExists('beallitasWorkSchedule')) {
            // Lefoglalja egy változóban, erre szükség van, mert ha offsetGet()-tel kapja meg, akkor a rendezés nem
            // működik.
            $workSchedules = $data->offsetGet('beallitasWorkSchedule');
            
            // Sorrend alapján rendezi a munkarendeket.
            usort($workSchedules, function($a, $b) {
                if ($a->sorrend == $b->sorrend) {
                    return 0;
                }

                return ($a->sorrend < $b->sorrend) ? -1 : 1;
            });
            
            // Átadja a már rendezett munkarendeket a nézetnek.
            $data->offsetSet('beallitasWorkSchedule', $workSchedules);
        }
    }
}
