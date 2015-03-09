<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Validator;
use Uniweb\Library\Validator\Interfaces\ValidatorInterface;

abstract class AbstractAllowNull implements ValidatorInterface
{
    /**
     * Engedélyezze-e a null értéket.
     * @var boolean
     */
    protected $allowNull;
    
    public function __construct($allowNull)
    {
        $this->allowNull = (boolean)$allowNull;
    }
    
    protected function nullValue($value)
    {
        return $this->allowNull === true ? is_null($value) : false;
    }
    /**
     * Visszatér az allowNull property értékével.
     * @return boolean
     */
    public function getAllowNull()
    {
        return $this->allowNull;
    }
    /**
     * Engedélyezze-e a NULL értéket.
     * @param boolean $allowNull
     */
    public function setAllowNull($allowNull)
    {
        $this->allowNull = (boolean)$allowNull;
    }
}