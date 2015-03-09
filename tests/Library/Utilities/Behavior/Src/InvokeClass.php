<?php
namespace Tests\Uniweb\Library\Utilities\Behavior\Src;

class InvokeClass
{
    protected $people = array();
    
    public function methodWithoutArguments()
    {
        return __FUNCTION__;
    }
    
    public function greet($name)
    {
        return 'Hello! My name is ' . (string)$name . '!';
    }
    
    public function greetVerbose($name, $town)
    {
        return $this->greet($name) . ' I live in ' . (string)$town . '!';
    }
    
    public function echoMyName($name)
    {
        echo $this->greet($name);
    }
    
    public function mergeArrays(array $array1, array $array2)
    {
        return array_merge($array1, $array2);
    }
    
    public function addPeople($name)
    {
        $this->people[] = $this->greet($name);
    }
    
    public static function sayGoodBye()
    {
        return 'Good Bye!';
    }
    
    public function getPeople()
    {
        return $this->people;
    }
}