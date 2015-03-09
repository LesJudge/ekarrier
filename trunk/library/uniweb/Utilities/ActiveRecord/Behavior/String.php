<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\AbstractBehavior;
use Uniweb\Library\Utilities\ActiveRecord\Assign\String as AssignString;

class String extends AbstractBehavior
{
    /**
     * String értéket tároló mező neve.
     * @var string
     */
    protected $stringAttribute;
    /**
     * Kötelező-e kitölteni a mezőt.
     * @var boolean
     */
    protected $required;
    /**
     * Maximális hossz.
     * @var null|int
     */
    protected $minLength;
    /**
     * Minimális hossz.
     * @var null|int
     */
    protected $maxLength;
    /**
     * Engedélyezze-e az egyenlő hosszúságot.
     * @var boolean
     */
    protected $allowEqualLength;
    
    public function __construct(
        $stringAttribute, 
        $required = true, 
        $minLength = 3, 
        $maxLength = 128, 
        $allowEqualLength = false
    ) {
        $this->stringAttribute = $stringAttribute;
        $this->required = (boolean)$required;
        $this->minLength = $this->stringLength($minLength);
        $this->maxLength = $this->stringLength($maxLength);
        $this->allowEqualLength = (boolean)$allowEqualLength;
    }
    
    public function validate()
    {
        $stringValue = $this->get_string();
        $stringLength = strlen($stringValue);
        if ($this->required === true && empty($stringValue)) {
            $this->owner->errors->add($this->stringAttribute, 'Kötelező mező!');
        }
        if (
            $stringLength > 0 
            && 
            !is_null($this->minLength) 
            && 
            !($this->allowEqualLength === true ? $stringLength >= $this->minLength : $stringLength > $this->minLength)
        ) {
            $min = $this->allowEqualLength === true ? $this->minLength : $this->minLength + 1;
            $this->owner->errors->add($this->stringAttribute, 'Legalább ' . $min . ' karakter hosszúnak kell lennie!');
        }
        if (
            $stringLength > 0 
            && 
            !is_null($this->maxLength) 
            && 
            !($this->allowEqualLength === true ? $stringLength <= $this->maxLength : $stringLength < $this->maxLength)
        ) {
            $max = $this->allowEqualLength === true ? $this->maxLength : $this->maxLength - 1;
            $this->owner->errors->add($this->stringAttribute, 'Legfeljebb ' . $max . ' karakter hosszú lehet!');
        }
    }
    
    public function get_string()
    {
        return $this->owner->read_attribute($this->stringAttribute);
    }
    
    public function set_string($string)
    {
        (new AssignString)->assignAttribute($this->stringAttribute, $string, $this->owner);
    }
    
    public function getStringAttribute()
    {
        return $this->stringAttribute;
    }
    
    public function getRequired()
    {
        return $this->required;
    }
    
    public function getMinLength()
    {
        return $this->minLength;
    }
    
    public function getMaxLength()
    {
        return $this->maxLength;
    }
    
    public function getAllowEqualsLength()
    {
        return $this->allowEqualLength;
    }
    
    public function setStringAttribute($stringAttribute)
    {
        $this->stringAttribute = $stringAttribute;
    }
    
    public function setRequired($required)
    {
        $this->required = (boolean)$required;
    }
    
    public function setMinLength($minLength)
    {
        $this->minLength = $this->stringLength($minLength);
    }
    
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $this->stringLength($maxLength);
    }
    
    public function setAllowEqualsLength($allowEqualLength)
    {
        $this->allowEqualLength = (boolean)$allowEqualLength;
    }
    
    private function stringLength($length)
    {
        return is_int($length) ? $length : null;
    }
}