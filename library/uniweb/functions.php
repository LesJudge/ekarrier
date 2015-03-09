<?php
namespace Uniweb\Functions;

function json_encode($value, $options = 0, $depth = 512)
{
    $args = func_get_args();
    if (is_object($value)) {
        $reflector = new \ReflectionObject($value);
        if ($reflector->implementsInterface('\\Uniweb\\Library\\Interfaces\\JsonSerializable')) {
            $args[0] = $reflector->getMethod('jsonSerialize')->invoke($value);
        }
    }
    return call_user_func_array('\\json_encode', $args);
}