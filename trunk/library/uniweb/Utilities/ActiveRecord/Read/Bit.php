<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Read;
use Uniweb\Library\Utilities\ActiveRecord\Interfaces\ReadAttributeInterface;

class Bit implements ReadAttributeInterface
{
    /**
     * BIT mező értékének kiolvasása.
     * @param string $name Attribútum neve.
     * @param \ActiveRecord\Model $on Model
     * @return mixed
     */
    public function readAttribute($name, \ActiveRecord\Model $on)
    {
        $value = $on->read_attribute($name);
        if (!is_null($value)) {
            //$value = ord($value);
            $value = (int)$value;
        }
        return $value;
    }
}