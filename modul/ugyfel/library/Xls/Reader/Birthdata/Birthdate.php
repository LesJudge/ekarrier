<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\Birthdata;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator\BirthData;

class Birthdate implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        $birthdata = new BirthData($client->birthdata);
        return $birthdata->getBirthDate();
    }
}