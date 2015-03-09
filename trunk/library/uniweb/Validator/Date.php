<?php
namespace Uniweb\Library\Validator;
use Uniweb\Library\Validator\Interfaces\ValidatorInterface;
use DateTime;

class Date implements ValidatorInterface
{
    /**
     * Formátum, ami szerint validál.
     * @var string
     */
    protected $format;
    
    public function validate($value)
    {
        if (is_scalar($value)) {
            $dateTime = DateTime::createFromFormat($this->format, $value);
            return $dateTime && $dateTime->format($this->format) == $value;
        }
        return false;
    }
    /**
     * Visszatér a formátummal, ami szerint validál.
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
    /**
     * Beállítja a formátumot, ami szerint validál.
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }
}