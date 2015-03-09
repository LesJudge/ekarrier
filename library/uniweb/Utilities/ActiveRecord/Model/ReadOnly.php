<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Model;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
use ReflectionProperty;

class ReadOnly extends ArBase
{
    public function after_construct()
    {
        $reflector = new ReflectionProperty('\\ActiveRecord\\Model', '__readonly');
        $reflector->setAccessible(true);
        $reflector->setValue($this, true);
    }
}