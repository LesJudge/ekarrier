<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class JobCategory implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        return $client->jobcategory->nev;
    }
}