<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Assign;
use Uniweb\Library\Utilities\ActiveRecord\Assign\AbstractAssignAttribute;
use ReflectionException;

class WithoutCast extends AbstractAssignAttribute
{
    public function assignAttribute($name, $value, $on, $flagDirty = true)
    {
        try {
            $this->setAttributeValue($name, $value, $on, $flagDirty);
            return $value;
        } catch (ReflectionException $re) {
            return null;
        }
    }
}