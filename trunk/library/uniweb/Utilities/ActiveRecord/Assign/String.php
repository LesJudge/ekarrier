<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Assign;
use Uniweb\Library\Utilities\ActiveRecord\Assign\AbstractAssignAttribute;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;

class String extends AbstractAssignAttribute
{
    public function assignAttribute($name, $value, $on, $flagDirty = true)
    {
        $withoutCast = new WithoutCast;
        if (is_string($value)) {
            $value = trim(preg_replace('/\s+/', ' ', $value));
        }
        return $withoutCast->assignAttribute($name, $value, $on, $flagDirty);
    }
}