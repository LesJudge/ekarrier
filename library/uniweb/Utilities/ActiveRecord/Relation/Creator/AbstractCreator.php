<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Relation\Creator;
use Uniweb\Library\Utilities\ActiveRecord\Interfaces\RelationCreatorInterface;

abstract class AbstractCreator implements RelationCreatorInterface
{
    /**
     * @var \ActiveRecord\Model
     */
    protected $model;
    /**
     * Visszatér a modellel.
     * @return \ActiveRecord\Model
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Beállítja a modelt.
     * @param \ActiveRecord\Model $model
     */
    public function setModel(\ActiveRecord\Model $model)
    {
        $this->model = $model;
    }
}