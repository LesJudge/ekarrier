<?php
namespace Uniweb\Module\Cim\Library;

interface AddressFinderInteface
{
    public function findAddress(array $fields, array $extra = array());
}