<?php
namespace Uniweb\Library\Utilities\ActiveRecord\SheepIt;
use Uniweb\Library\Interfaces\JsonSerializable;

class JsonSerializeModel implements JsonSerializable
{
    /**
     * Serializálandó model.
     * @var \ActiveRecord\Model
     */
    protected $serialized;
    /**
     * Prefix.
     * @var string
     */
    protected $prefix;
    /**
     * Attribútumok, amelyeket serializál.
     * @var array
     */
    protected $properties = array();

    public function __construct(\ActiveRecord\Model $serialized, $prefix = '', array $properites = array())
    {
        $this->serialized = $serialized;
        $this->prefix = $prefix;
        $this->properties = !empty($properites) ? $properites : array_keys($serialized->attributes());
    }
    
    public function jsonSerialize()
    {
        $errors = $this->serialized->errors;
        $attributes = $this->serialized->attributes();
        $doNotSearch = $attributes === $this->properties;
        $serialized = array();
        $prefix = $this->prefix == '' ? $prefix : $this->prefix . '_';
        foreach ($this->properties as $property) {
            if ($doNotSearch || in_array($property, $attributes)) {
                $value = $this->serialized->{$property};
                if (!is_scalar($value)) {
                    $value = \Uniweb\Functions\json_encode($value);
                }
                $serialized[$prefix . $property] = $value;
            } else {
                $serialized[$prefix . $property] = '';
            }
            if (!is_null($errors) && $errors->on($property)) {
                $serialized[$prefix . $property . '_error'] = $errors->on($property);
            } else {
                $serialized[$prefix . $property . '_error'] = '';
            }
        }
        return $serialized;
    }
    /**
     * Visszatér a serializálandó objektummal.
     * @return \ActiveRecord\Model
     */
    public function getSerialized()
    {
        return $this->serialized;
    }
    /**
     * Beállítja a serializálandó modelt.
     * @param \ActiveRecord\Model $serialized Serializálandó model.
     */
    public function setSerialized(\ActiveRecord\Model $serialized)
    {
        $this->serialized = $serialized;
    }
}