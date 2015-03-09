<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\ProjectInformation;
use Uniweb\Module\Ugyfel\Library\Xls\Reader\AbstractTrueOrFalse;

class HozJarulMunkakozv extends AbstractTrueOrFalse
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        return $this->createReadableValue($client->projectinformation->hozzajarul_a_munkakozvetiteshez);
    }
}