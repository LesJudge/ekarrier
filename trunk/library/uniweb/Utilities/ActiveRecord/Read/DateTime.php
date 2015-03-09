<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Read;
use Uniweb\Library\Utilities\ActiveRecord\Interfaces\ReadAttributeInterface;

class DateTime implements ReadAttributeInterface
{
    protected $format;
    
    public function __construct($format)
    {
        $this->format = $format;
    }
    
    public function readAttribute($name, \ActiveRecord\Model $on)
    {
        $value = $on->read_attribute($name);
        if (is_object($value) && $value instanceof \ActiveRecord\DateTime) {
            return $value->format($this->format);
        }
        return null;
    }
    
    public function getFormat()
    {
        return $this->format;
    }
    
    public function setFormat($format)
    {
        $this->format = $format;
    }
}