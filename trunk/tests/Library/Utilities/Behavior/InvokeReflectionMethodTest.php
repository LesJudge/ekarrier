<?php
namespace Tests\Uniweb\Library\Utilities\Behavior;
use Tests\Uniweb\Library\Utilities\Behavior\Src\InvokeClass;
use Uniweb\Library\Utilities\Behavior\InvokeReflectionMethod;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

class InvokeReflectionMethodTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ReflectionClass
     */
    public $reflector;
    /**
     * @var \Uniweb\Library\Utilities\Behavior\InvokeReflectionMethod
     */
    public $invoker;
    
    public function testDoesItWorkCorrectlyWithoutArguments()
    {
        $method = $this->reflector->getMethod('methodWithoutArguments');
        $this->assertEquals(
            $method->getName(), $this->invoker->invoke($method, $this->reflector->newInstanceWithoutConstructor())
        );
    }
    
    public function testDoesItWorkCorrectlyWithOneArgument()
    {
        $method = $this->reflector->getMethod('greet');
        $this->assertEquals(
            'Hello! My name is John!', 
            $this->invoker->invoke($method, $this->reflector->newInstanceWithoutConstructor(), 'John')
        );
    }
    
    public function testDoesItWorkCorrectlyWithMultipleArguments()
    {
        $method = $this->reflector->getMethod('greetVerbose');
        $on = $this->reflector->newInstanceWithoutConstructor();
        $this->assertEquals(
            'Hello! My name is Jane! I live in England!', 
            $this->invoker->invoke($method, $on, array('Jane', 'England'))
        );
        
        $method = $this->reflector->getMethod('mergeArrays');
        $this->assertEquals(range(1, 6), $this->invoker->invoke($method, $on, array(array(1, 2), array(3, 4, 5, 6))));
    }
    
    public function testDoesItWorkCorrectlyWhenMethodHasNotReturnValue()
    {
        $method = $this->reflector->getMethod('echoMyName');
        ob_start();
        $this->invoker->invoke($method, $this->reflector->newInstanceWithoutConstructor(), 'Jack');
        $greet = ob_get_clean();
        $this->assertEquals('Hello! My name is Jack!', $greet);
        
        $method = $this->reflector->getMethod('addPeople');
        $on = $this->reflector->newInstanceWithoutConstructor();
        $this->invoker->invoke($method, $on, 'John');
        $this->invoker->invoke($method, $on, 'Jane');
        $this->invoker->invoke($method, $on, 'Jack');
        
        $expected = array(
            0 => 'Hello! My name is John!',
            1 => 'Hello! My name is Jane!',
            2 => 'Hello! My name is Jack!'
        );
        $this->assertEquals($expected, $this->invoker->invoke($this->reflector->getMethod('getPeople'), $on));
    }
    
    public function testDoesItWorkCorrectlyWithStaticMethodsWithoutArguments()
    {
        $method = $this->reflector->getMethod('sayGoodBye');
        $this->assertEquals(InvokeClass::sayGoodBye(), $this->invoker->invoke($method, null));
    }
    /**
     * @expectedException ReflectionException
     * @expectedExceptionMessage Az on paraméter csak statikus metódus esetében lehet null!
     */
    public function testDoesItThrowAReflectionExceptionWhenICallANonStaticMethodStatically()
    {
        $method = $this->reflector->getMethod('greet');
        $this->assertEquals('Hello! My name is John!', $this->invoker->invoke($method, null, 'John'));
    }
    
    public function setUp()
    {
        $this->reflector = new ReflectionClass('\\Tests\\Uniweb\\Library\\Utilities\\Behavior\\Src\\InvokeClass');
        $this->invoker = new InvokeReflectionMethod;
    }
}