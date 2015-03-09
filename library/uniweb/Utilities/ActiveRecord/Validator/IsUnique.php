<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Validator;
use Uniweb\Library\Validator\Interfaces\ValidatorInterface;

class IsUnique implements ValidatorInterface
{
    /**
     * Mező, aminek egyedinek kell lennie.
     * @var string
     */
    protected $field;
    /**
     * Model
     * @var \ActiveRecord\Model
     */
    protected $model;
    
    public function __construct(\ActiveRecord\Model $model, $field)
    {
        $this->model = $model;
        $this->field = $field;
    }
    /**
     * Megvizsgálja, hogy egyedi-e a rekord.
     * @param scalar $value Érték.
     * @return boolean
     */
    public function validate($value)
    {
        $pk = $this->model->get_primary_key(true);
        return !$this->model->exists(array(
            'conditions' => array(
                $pk . ' != ? AND ' . $this->field . ' = ?', (int)$this->model->{$pk}, $value
            )
        ));
    }
    /**
     * Visszatér az elsődleges kulccsal.
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
    /**
     * Visszatér a validálandó modellel.
     * @return \ActiveRecord\Model
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Beállítja az elsődleges kulcsot.
     * @param string $field Elsődleges kulcs.
     */
    public function setField($field)
    {
        $this->field = $field;
    }
    /**
     * Beállítja a validálandó modelt.
     * @param \ActiveRecord\Model $model
     */
    public function setModel(\ActiveRecord\Model $model)
    {
        $this->model = $model;
    }
}