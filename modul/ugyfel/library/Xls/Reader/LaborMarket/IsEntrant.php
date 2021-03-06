<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\LaborMarket;
use Uniweb\Module\Ugyfel\Library\Xls\Reader\AbstractTrueOrFalse;

class IsEntrant extends AbstractTrueOrFalse
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        return $this->createReadableValue($client->labormarket->palyakezdo);
    }
}