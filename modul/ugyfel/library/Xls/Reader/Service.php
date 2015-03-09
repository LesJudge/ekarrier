<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class Service implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        /* @var $services \Uniweb\Module\Ugyfel\Model\ActiveRecord\ServiceInterested */
        $services = $client->services;
        $data = array();
        if (is_array($services) && !empty($services)) {
            foreach ($services as $service) {
                $data[] = $service->service->nev;
            }
        }
        return $data;
    }
}