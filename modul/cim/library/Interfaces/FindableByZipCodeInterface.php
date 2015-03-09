<?php
namespace Uniweb\Module\Cim\Library\Interfaces;

interface FindableByZipCodeInterface
{
    public function findByZipCodeId($zipCodeId);
    
    public function findByZipCode($zipCode);
}