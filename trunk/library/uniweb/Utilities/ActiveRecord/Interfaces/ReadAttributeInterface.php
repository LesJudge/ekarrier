<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Interfaces;

interface ReadAttributeInterface
{
    /**
     * @param string $name Attribútum neve..
     * @param \ActiveRecord\Model $on Az objektum, amiből kinyeri az értéket.
     */
    public function readAttribute($name, \ActiveRecord\Model $on);
}