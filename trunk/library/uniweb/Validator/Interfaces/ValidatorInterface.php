<?php
namespace Uniweb\Library\Validator\Interfaces;

interface ValidatorInterface
{
    /**
     * Validáció végrehajtása.
     * @param mixed $value Az érték, amit validáli kell.
     * @return boolean Sikeres volt-e a validáció.
     */
    public function validate($value);
}