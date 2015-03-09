<?php
namespace Uniweb\Module\Cim\Library\Interfaces;

interface FindableByCityInterface
{
    public function findByCityId($cityId);
    
    public function findByCityName($cityName);
}