<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Validator;
use Uniweb\Library\Utilities\ActiveRecord\Validator\AbstractAllowNull;

class Timestamp extends AbstractAllowNull
{
    public function validate($value)
    {
        return (is_object($value) && $value instanceof \ActiveRecord\DateTime) || $this->nullValue($value);
    }
}