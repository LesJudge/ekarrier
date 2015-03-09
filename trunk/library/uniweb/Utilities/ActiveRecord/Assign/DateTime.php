<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Assign;
use Uniweb\Library\Utilities\ActiveRecord\Assign\AbstractAssignAttribute;
use Uniweb\Library\Validator\Date;
use ReflectionException;

class DateTime extends AbstractAssignAttribute
{
    /**
     * Dátum formátum, aminek meg kell felelnie.
     * @var string
     */
    protected $format;
    
    public function __construct($format)
    {
        $this->format = $format;
    }
    
    public function assignAttribute($name, $value, $on, $flagDirty = true)
    {
        try {
            $date = new Date;
            $date->setFormat($this->format);
            if ($date->validate($value)) {
                $value = new \ActiveRecord\DateTime($value);
                $value->attribute_of($on, $name);
            } else {
                $value = false;
            }
            $this->setAttributeValue($name, $value, $on, $flagDirty);
            return $value;
        } catch (ReflectionException $re) {
            return false;
        }
    }
    /**
     * Visszatér a formátummal.
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
    /**
     * Beállítja a formátumot, aminek meg kell felelnie.
     * @param string $format Formátum.
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }
}