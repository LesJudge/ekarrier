<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Interfaces;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;

interface ReaderInterface
{
    public function read(Client $client);
}