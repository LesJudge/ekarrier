<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

class Education implements ReaderInterface
{
    public function read(\Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client)
    {
        /* @var $educations \Uniweb\Module\Ugyfel\Model\ActiveRecord\Education */
        $educations = $client->educations;
        $data = array();
        if (is_array($educations) && !empty($educations)) {
            foreach ($educations as $education) {
                $data[] = $education->megnevezes;
            }
        }
        return $data;
    }
}