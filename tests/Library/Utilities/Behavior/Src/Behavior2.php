<?php
namespace Tests\Uniweb\Library\Utilities\Behavior\Src;
use Uniweb\Library\Utilities\Behavior\AbstractBehavior;
use ReflectionProperty;

class Behavior2 extends AbstractBehavior
{
    public function method1()
    {
        return 'behavior2 - method1';
    }
    
    public function method2()
    {
        return 'behavior2 - method2';
    }
    
    public function pear()
    {
        return 'pear';
    }
    
    public function beforeSomething()
    {
        $reflectionProperty = new ReflectionProperty($this->owner, 'beforeSomethings');
        $reflectionProperty->setAccessible(true);
        $value = $reflectionProperty->getValue($this->owner);
        $value[] = 'Behavior2';
        $reflectionProperty->setValue($this->owner, $value);
    }
    
    public function getPublicProperty()
    {
        return 'behavior2: ' . $this->owner->publicProperty;
    }
    
    public function getProtectedProperty()
    {
        $reflector = new ReflectionProperty(get_class($this->owner), 'protectedProperty');
        $reflector->setAccessible(true);
        return 'behavior2: ' . $reflector->getValue($this->owner);
    }
    
    public function getPrivateProperty()
    {
        $reflector = new ReflectionProperty(get_class($this->owner), 'privateProperty');
        $reflector->setAccessible(true);
        return $reflector->getValue($this->owner);
    }
    
    public function setPublicProperty($publicProperty)
    {
        $this->owner->publicProperty = $publicProperty;
    }
    
    public function setProtectedProperty($protectedProperty)
    {
        $reflector = new ReflectionProperty(get_class($this->owner), 'privateProperty');
        $reflector->setAccessible(true);
        $reflector->setValue($this->owner, $protectedProperty);
    }
    
    public function setPrivateProperty($privateProperty)
    {
        $reflector = new ReflectionProperty(get_class($this->owner), 'privateProperty');
        $reflector->setAccessible(true);
        $reflector->setValue($this->owner, $privateProperty);
    }
}