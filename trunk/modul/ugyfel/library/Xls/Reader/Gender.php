<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class Gender implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        switch ($client->nem) {
            case 'male':
                return 'F';
                break;
            case 'female':
                return 'N';
                break;
            default:
                return '';
                break;
        }
    }
}