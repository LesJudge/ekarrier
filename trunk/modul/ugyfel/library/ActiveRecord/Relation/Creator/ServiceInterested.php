<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Relation\Creator\CreateByData;

class ServiceInterested extends CreateByData
{
    public function create($data)
    {
        $setCheck = function($index, $default) use (&$data) {
            if (!isset($data[$index])) {
                $data[$index] = $default;
            }
        };
        $setCheck('reszt_akar_venni', 0);
        $setCheck('reszt_vett', 0);
        /* @var $serviceInterested \Uniweb\Module\Ugyfel\Model\ActiveRecord\ServiceInterested */
        $serviceInterested = parent::create($data);
        $serviceInterested->ugyfel_attr_szolgaltatas_erdekelt_torolt = 0;
        return $serviceInterested;
    }
}