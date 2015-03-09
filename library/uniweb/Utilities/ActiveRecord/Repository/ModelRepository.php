<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Repository;
use Uniweb\Library\Interfaces\ModelRepositoryInterface;

class ModelRepository implements ModelRepositoryInterface
{
    /**
     * @var \ActiveRecord\Model
     */
    protected $model;
    
    public function __construct(\ActiveRecord\Model $model)
    {
        $this->model = $model;
    }
    
    public function create($attributes, $validate = true)
    {
        return $this->model->create($attributes, $validate);
    }

    public function delete($options)
    {
        return $this->model->delete_all($options);
    }

    public function find($options = array())
    {
        return $this->model->find($options);
    }

    public function findById($id, $options = array())
    {
        return $this->model->find_by_pk($id, $options);
    }

    public function update($options)
    {
        return $this->model->update_all($options);
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