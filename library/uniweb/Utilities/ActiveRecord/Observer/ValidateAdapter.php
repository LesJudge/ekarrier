<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Observer;
use Uniweb\Library\Utilities\ActiveRecord\Observer\AbstractAdapter;
use Uniweb\Library\Resource\Observer\Interfaces\ValidatableInterface;

class ValidateAdapter extends AbstractAdapter implements ValidatableInterface
{
    public function validate()
    {
        return $this->model->is_valid();
    }
}