<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Interfaces;

interface AttributeModifierInterface
{
    /**
     * Módosítja a paraméterül adott értéket.
     * @param mixed $attributes Attribútum(ok), amit módosít.
     */
    public function modifyAttributes(&$attributes);
}