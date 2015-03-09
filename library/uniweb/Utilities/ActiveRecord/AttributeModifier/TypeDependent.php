<?php
namespace Uniweb\Library\Utilities\ActiveRecord\AttributeModifier;
use Uniweb\Library\Utilities\ActiveRecord\Interfaces\AttributeModifierInterface;

class TypeDependent implements AttributeModifierInterface
{
    /**
     * Típus azonosító.
     * @var int
     */
    protected $typeId;
    /**
     * Típus attribútum neve.
     * @var string
     */
    protected $typeAttribute;
    /**
     * Hozzáadja a conditions indexhez a szükséges paramétereket.
     * @param mixed $attributes
     */
    public function modifyAttributes(&$attributes)
    {
        if (empty($attributes['conditions']) || \ActiveRecord\is_hash($attributes['conditions'])) {
            $attributes['conditions'][$this->typeAttribute] = $this->typeId;
        } else {
            $attributes['conditions'][0] .= ' AND ' . $this->typeAttribute . ' = ?';
            $attributes['conditions'][] = $this->typeId;
        }
    }
    /**
     * Visszatér a típus azonosítóval.
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }
    /**
     * Beállítja a típus attribútumot.
     * @return string
     */
    public function getTypeAttribute()
    {
        return $this->typeAttribute;
    }
    /**
     * Beállítja a típus azonosítót.
     * @param int $typeId Típus azonosító.
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }
    /**
     * Beállítja a típus attribútum nevét.
     * @param string $typeAttribute Típus attribútum neve.
     */
    public function setTypeAttribute($typeAttribute)
    {
        $this->typeAttribute = $typeAttribute;
    }
}