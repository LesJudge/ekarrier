<?php
namespace Uniweb\Module\Cim\Library\Interfaces;

interface FindableByCountryInterface
{
    public function findByCountryId($countryId);
    
    public function findByCountryName($countryName);
}