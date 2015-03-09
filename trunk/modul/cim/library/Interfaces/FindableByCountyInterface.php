<?php
namespace Uniweb\Module\Cim\Library\Interfaces;

interface FindableByCountyInterface
{
    public function findByCountyId($countyId);
    
    public function findByCountyName($countyName);
}