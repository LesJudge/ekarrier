<?php

interface ResourcableInterface
{
    /**
     * Visszatér az erőforrás kulcsával.
     * @return string
     */
    public static function getResourceKey();
}