<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord\Decorator;

class AbstractClientDataDecorator
{
    protected function getBitValue($value, $default = '')
    {
        if (!is_null($value)) {
            return $value == 1 ? 'Igen' : 'Nem';
        }
        return $default;
    }
    
    protected function getValue($value, $default = '')
    {
        return is_null($value) ? $default : $value;
    }
    /*
    protected function getTimestampValue($value, $default)
    {
        if (is_object($value) && $value instanceof \ActiveRecord\DateTime) {
            return $value->format();
        }
        return $default;
    }
    */
}