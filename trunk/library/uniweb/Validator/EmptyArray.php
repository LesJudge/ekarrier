<?php
namespace Uniweb\Library\Validator;
use Uniweb\Library\Validator\Interfaces\ValidatorInterface;

class EmptyArray implements ValidatorInterface
{
    public function validate($value)
    {
        return is_array($value) && count($value) == 0;
    }
}