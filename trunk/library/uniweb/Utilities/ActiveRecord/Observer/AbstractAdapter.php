<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Observer;
use ReflectionObject;
use InvalidArgumentException;

abstract class AbstractAdapter
{
    /**
     * @var \ActiveRecord\Model|\Uniweb\Library\Resource\Interfaces\ResourcableInterface
     */
    protected $model;
    
    public function __construct(\ActiveRecord\Model $model)
    {
        $this->setModel($model);
    }
    /**
     * Visszatér a modellel.
     * @return \ActiveRecord\Model|\Uniweb\Library\Resource\Interfaces\ResourcableInterface
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Beállítja a modelt.
     * @param \ActiveRecord\Model $model Model.
     * @throws InvalidArgumentException
     */
    public function setModel(\ActiveRecord\Model $model)
    {
        $reflector = new ReflectionObject($model);
        if ($reflector->implementsInterface('\\Uniweb\\Library\\Resource\\Interfaces\\ResourcableInterface')) {
            $this->model = $model;
        } else {
            throw new InvalidArgumentException(
                'Az objektumnak implementálnia kell a ResourcableInterface interface-t!'
            );
        }
    }
}