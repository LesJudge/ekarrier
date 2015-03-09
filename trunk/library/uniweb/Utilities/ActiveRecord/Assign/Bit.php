<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Assign;
use Uniweb\Library\Utilities\ActiveRecord\Interfaces\AssignAttributeInterface;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;

class Bit implements AssignAttributeInterface
{
    /**
     * BIT mező értékének beállítása.
     * @param string $name Attribútum neve.
     * @param mixed $value Attribútum értéke.
     * @param \ActiveRecord\Model $on Model
     */
    public function assignAttribute($name, $value, $on, $flagDirty = true)
    {
        $assign = new WithoutCast;
        return $assign->assignAttribute($name, is_null($value) ? null : chr($value), $on, $flagDirty);
    }
}
