<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Validator;
use Uniweb\Library\Utilities\ActiveRecord\Validator\AbstractAllowNull;
use Uniweb\Library\Validator\NaturalNumber;

class ForeignKey extends AbstractAllowNull
{
    /**
     * Megvizsgálja a paraméterül adott értéket.
     * @param mixed $value Érték, amit megvizsgál.
     * @return boolean
     */
    public function validate($value)
    {
        $naturalNumber = new NaturalNumber;
        return $naturalNumber->validate($value) || $this->nullValue($value);
    }
}