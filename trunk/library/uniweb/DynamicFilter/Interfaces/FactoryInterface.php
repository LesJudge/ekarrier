<?php
namespace Uniweb\Library\DynamicFilter\Interfaces;

interface FactoryInterface
{
    /**
     * Szűrő osztály név alapján példányosítja a szűrő objektumot.
     * @param string $type Szűrő osztály neve.
     * @param array $settings Szűrő beállítások.
     * @return \Uniweb\Library\DynamicFilter\Interfaces\FilterInterface Filter objektum.
     */
    public function factory($type, array $settings = array());
}