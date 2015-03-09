<?php
namespace Uniweb\Library\Validator;
use Uniweb\Library\Validator\Interfaces\ValidatorInterface;
/**
 * Természetes szám validátor.
 * 
 * Értelemszerűen azt a célt szolgálja, hogy egy számról eldöntsük természetes szám-e vagy sem.
 */
class NaturalNumber implements ValidatorInterface
{
    /**
     * A 0 természetes számnak minősül-e a vizsgálat során.
     * @var boolean
     */
    protected $zeroIsNatural = false;
    /**
     * Megvizsgálja, hogy a paraméterül adott érték természetes szám-e.
     * @param mixed $value Az érték, amit meg kell vizsgálnia.
     * @return boolean
     */
    public function validate($value)
    {
        return is_int($value) && $value >= ($this->zeroIsNatural === true ? 0 : 1);
    }
    /**
     * Visszatér azzal az értékkel, hogy a 0 természetes számnak számít-e a validáció során vagy sem.
     * @return boolean
     */
    public function getZeroIsNatural()
    {
        return $this->zeroIsNatural;
    }
    /**
     * Beállítja, hogy a 0 természetes számnak számít-e a validáció során.
     * @param boolean $zeroIsNatural
     */
    public function setZeroIsNatural($zeroIsNatural)
    {
        $this->zeroIsNatural = (boolean)$zeroIsNatural;
    }
}