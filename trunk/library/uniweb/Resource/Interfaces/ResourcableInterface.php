<?php
namespace Uniweb\Library\Resource\Interfaces;

interface ResourcableInterface
{
    /**
     * Visszatér az erőforrás kulcsával.
     * @return string
     */
    public static function getResourceKey();
}