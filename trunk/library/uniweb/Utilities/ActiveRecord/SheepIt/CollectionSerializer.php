<?php
namespace Uniweb\Library\Utilities\ActiveRecord\SheepIt;
use Uniweb\Library\Interfaces\JsonSerializable;
use ReflectionClass;

class CollectionSerializer implements JsonSerializable
{
    protected $collection;
    
    protected $parameters;
    
    public function __construct(array $collection, array $parameters)
    {
        $this->collection = $collection;
        $this->parameters = $parameters;
    }
    
    public function jsonSerialize()
    {
        $json = array();
        if (!empty($this->collection)) {
            foreach ($this->collection as $item) {
                $reflector = new ReflectionClass(
                    '\\Uniweb\\Library\\Utilities\\ActiveRecord\\SheepIt\\JsonSerializeModel'
                );
                $serializer = $reflector->newInstance($item, $this->parameters[0], $this->parameters[1]);
                $json[] = $serializer->jsonSerialize();
            }
        }
        return $json;
    }
    
    public function getCollection()
    {
        return $this->collection;
    }
    
    public function getParameters()
    {
        return $this->parameters;
    }
}