<?php
namespace Uniweb\Library\Utilities\Behavior;
use ReflectionMethod;
use ReflectionException;

class InvokeReflectionMethod
{
    public static function invoke(ReflectionMethod $method, $on = null, $arguments = null)
    {
        if (is_object($on) || $method->isStatic()) {
            $type = gettype($arguments);
            switch ($type) {
                case 'null':
                    $value = $method->invoke($on);
                    break;
                case 'array':
                    $value = $method->invokeArgs($on, $arguments);
                    break;
                default:
                    $value = $method->invoke($on, $arguments);
                    break;
            }
            if (!is_null($value)) {
                return $value;
            }            
        } else {
            throw new ReflectionException('Az on paraméter csak statikus metódus esetében lehet null!');
        }
    }
}