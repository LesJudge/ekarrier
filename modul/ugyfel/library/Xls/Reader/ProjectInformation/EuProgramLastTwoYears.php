<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\ProjectInformation;
use Uniweb\Module\Ugyfel\Library\Xls\Reader\AbstractTrueOrFalse;

class EuProgramLastTwoYears extends AbstractTrueOrFalse
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        return $this->createReadableValue($client->projectinformation->eu_prog_elm_ket_ev);
    }
}