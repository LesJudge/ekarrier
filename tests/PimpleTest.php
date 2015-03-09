<?php
use Pimple\Container;

class PimpleTest extends PHPUnit_Framework_TestCase
{
    public function testFirst()
    {
        $container = new Container;
        
        $this->assertFalse($container->offsetExists('ns.subns.class1'));
        
        $container['ns.subns.class1'] = $container->factory(function($c) {
            return new Class1();
        });
        
        $this->assertTrue($container->offsetExists('ns.subns.class1'));
        
        $this->assertInstanceOf('Class1', $container['ns.subns.class1']);
        
        $provider = new Provider;
        $container->register($provider);
        
        $class1 = $container['ns.subns.class1'];
        
        
        $this->assertInstanceOf('Class1', $class1);
        
        $object1 = $container->offsetGet('class1myclass1');
        $object2 = $container->offsetGet('class1myclass2');
        
        $this->assertInstanceOf('Class1', $object1);
        $this->assertInstanceOf('Class1', $object2);
        $this->assertInstanceOf('MyClass1', $object1->dependency);
        $this->assertInstanceOf('MyClass2', $object2->dependency);
    }
}

class Class1
{
    public $dependency;
    
    public function setDependency($dependency)
    {
        $this->dependency = $dependency;
    }
}

class MyClass1
{
    public function getClassName()
    {
        return __CLASS__;
    }
}

class MyClass2
{
    public function getClassName()
    {
        return __CLASS__;
    }
}

class Provider implements \Pimple\ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['class1myclass1'] = $pimple->factory(function($c) {
            $instance = new Class1;
            $instance->setDependency(new MyClass1);
            return $instance;
        });
        
        $pimple['class1myclass2'] = $pimple->factory(function($c) {
            $instance = new Class1;
            $instance->setDependency(new MyClass2);
            return $instance;
        });
    }
}