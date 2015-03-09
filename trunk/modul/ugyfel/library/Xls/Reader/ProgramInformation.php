<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class ProgramInformation implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        /* @var $programInformations \Uniweb\Module\Ugyfel\Model\ActiveRecord\ProgramInformation */
        $programInformations = $client->programinformations;
        $data = array();
        if (is_array($programInformations) && !empty($programInformations)) {
            foreach ($programInformations as $programInformation) {
                $data[] = $programInformation->programinformation->nev;
            }
        }
        return $data;
    }
}