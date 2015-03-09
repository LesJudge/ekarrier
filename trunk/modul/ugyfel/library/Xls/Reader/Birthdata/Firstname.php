<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader\Birthdata;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class Firstname implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        return $client->birthdata->keresztnev;
    }
}