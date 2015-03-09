<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\Phone;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class MobileSecondary implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        return $client->telefonszam_mobil2;
    }
}