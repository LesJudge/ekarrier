<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Relation;
use ReflectionClass;
/**
 * AR Model kapcsolat kiolvasó osztály.
 */
class Reader
{
    /**
     * @var \ActiveRecord\Model
     */
    protected $model;
    /**
     * @param \ActiveRecord\Model $model Model, aminek ki kell olvasni a kapcsolatait.
     */
    public function __construct(\ActiveRecord\Model $model)
    {
        $this->model = $model;
    }
    /**
     * Visszatér a model kapcsolataival.
     * @return \ActiveRecord\AbstractRelationship[]
     */
    public function read()
    {
        $reflector = new ReflectionClass('\\ActiveRecord\\Table');
        $relationshipsProperty = $reflector->getProperty('relationships');
        $relationshipsProperty->setAccessible(true);
        return $relationshipsProperty->getValue($this->model->table());
    }
    /**
     * Visszatér a modellel.
     * @return \ActiveRecord\Model
     */
    public function getModel()
    {
        return $this->model;
    }
}