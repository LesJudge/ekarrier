<?php
namespace Tests\Uniweb\Library\Utilities\Behavior\Src;
use Uniweb\Library\Utilities\Behavior\AbstractBehavior;
use ReflectionProperty;

class Behavior1 extends AbstractBehavior
{    
    public function method1()
    {
        return 'behavior1 - method1';
    }
    
    public function method2()
    {
        return 'behavior1 - method2';
    }
    
    public function apple()
    {
        return 'apple';
    }
    
    public function beforeSomething()
    {
        $reflectionProperty = new ReflectionProperty($this->owner, 'beforeSomethings');
        $reflectionProperty->setAccessible(true);
        $value = $reflectionProperty->getValue($this->owner);
        $value[] = 'Behavior1';
        $reflectionProperty->setValue($this->owner, $value);
    }
    
    public function notRequiredCallback()
    {
        echo __METHOD__, PHP_EOL;
    }
    
    public function getPublicProperty()
    {
        return 'behavior1: ' . $this->owner->publicProperty;
    }
    
    public function getProtectedProperty()
    {
        $reflector = new ReflectionProperty(get_class($this->owner), 'protectedProperty');
        $reflector->setAccessible(true);
        return 'behavior1: ' . $reflector->getValue($this->owner);
    }
    
    public function getPrivateProperty()
    {
        return 'Please use reflection to read privateProperty\'s value!';
    }
    
    public function setPublicProperty($publicProperty)
    {
        $this->owner->publicProperty = $publicProperty;
    }
    
    public function setProtectedProperty($protectedProperty)
    {
        $reflector = new ReflectionProperty(get_class($this->owner), 'protectedProperty');
        $reflector->setAccessible(true);
        $reflector->setValue($this->owner, $protectedProperty);
    }
}