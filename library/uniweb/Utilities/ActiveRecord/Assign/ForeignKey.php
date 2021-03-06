<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Assign;
use Uniweb\Library\Utilities\ActiveRecord\Assign\AbstractAssignAttribute;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;

class ForeignKey extends AbstractAssignAttribute
{
    public function assignAttribute($name, $value, $on, $flagDirty = true)
    {
        if ($value == '') {
            $value = null;
        }
        $withoutCast = new WithoutCast;
        return $withoutCast->assignAttribute($name, $value, $on, $flagDirty);
    }
}