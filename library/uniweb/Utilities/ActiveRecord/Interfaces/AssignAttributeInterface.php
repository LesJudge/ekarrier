<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Interfaces;

interface AssignAttributeInterface
{
    /**
     * @param string $name Attribútum neve.
     * @param mixed $value Attribútum értéke.
     * @param object $on Az objektum, amelyben beállítja az attribútum értékét.
     * @param boolean $flagDirty Jelölje-e meg "piszkos"-ként az attribútumot.
     */
    public function assignAttribute($name, $value, $on, $flagDirty = true);
}