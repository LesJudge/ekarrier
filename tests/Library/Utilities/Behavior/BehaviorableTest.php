<?php
namespace Tests\Uniweb\Library\Utilities\Behavior;
use Tests\Uniweb\Library\Utilities\Behavior\Src\Behavior1;
use Tests\Uniweb\Library\Utilities\Behavior\Src\Behavior2;
use Tests\Uniweb\Library\Utilities\Behavior\Src\Behavior3;
use Tests\Uniweb\Library\Utilities\Behavior\Src\BehaviorableClass;
use PHPUnit_Framework_TestCase;

class BehaviorableTest extends PHPUnit_Framework_TestCase
{
    protected $behaviorable;
    
    public function testDoesAttachBehaviorsWorksCorrectly()
    {
        $this->assertCount(3, $this->behaviorable->getBehaviorContainer());
        
        foreach ($this->behaviorable->getBehaviorContainer() as $behavior) {
            /* @var $behavior \Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface */
            $this->assertInstanceOf(
                '\\Tests\\Uniweb\\Library\\Utilities\\Behavior\\Src\\BehaviorableClass', 
                $behavior->getOwner()
            );
        }
    }
    
    public function testDoesDetachBehaviorsWorksCorrectly()
    {
        $this->assertCount(3, $this->behaviorable->getBehaviorContainer());
        
        $this->behaviorable->detachBehavior('behavior1');
        $this->behaviorable->detachBehavior('behavior2');
        $this->behaviorable->detachBehavior('behavior3');
        
        $this->assertCount(0, $this->behaviorable->getBehaviorContainer());
    }
    
    public function testDoesItExecuteCorrectMethodsOnBehaviors()
    {
        $this->assertEquals('behavior1 - method1', $this->behaviorable->in('behavior1')->method1());
        $this->assertEquals('behavior2 - method1', $this->behaviorable->in('behavior2')->method1());
        $this->assertEquals('behavior1 - method2', $this->behaviorable->in('behavior1')->method2());
        $this->assertEquals('behavior2 - method2', $this->behaviorable->in('behavior2')->method2());
        $this->assertEquals('behavior2 - method1', $this->behaviorable->in('behavior2', 'behavior1')->method1());
        $this->assertEquals('behavior2 - method2', $this->behaviorable->in('behavior2', 'behavior1')->method2());
        $this->assertEquals('behavior1 - method1', $this->behaviorable->in('behavior1', 'behavior2')->method1());
        $this->assertEquals('behavior1 - method2', $this->behaviorable->in('behavior1', 'behavior2')->method2());
        
        $this->assertEquals('behavior1 - method1', $this->behaviorable->method1());
        $this->assertEquals('behavior1 - method1', $this->behaviorable->in('behavior1')->method1());
        $this->assertEquals('behavior1 - method1', $this->behaviorable->in('behavior1', 'behavior2')->method1());
        
        $this->behaviorable->detachBehavior('behavior1');
        $this->behaviorable->detachBehavior('behavior2');
        $this->behaviorable->detachBehavior('behavior3');
        
        $this->assertCount(0, $this->behaviorable->getBehaviorContainer());
        
        $this->setUp();
        
        $this->assertCount(3, $this->behaviorable->getBehaviorContainer());
        
        $this->behaviorable->getBehaviorContainer()->detachBehavior('behavior1');
        
        $this->assertCount(2, $this->behaviorable->getBehaviorContainer());
        $this->assertEquals('behavior2 - method1', $this->behaviorable->method1());
        $this->assertEquals('behavior2 - method2', $this->behaviorable->method2());
        
        $this->setUp();
        
        $this->assertEquals('behavior1: publicProperty', $this->behaviorable->getPublicProperty());
        $this->assertEquals('behavior1: protectedProperty', $this->behaviorable->getProtectedProperty());
        $this->assertEquals(
            'Please use reflection to read privateProperty\'s value!', $this->behaviorable->getPrivateProperty()
        );
        
        $this->behaviorable->setPublicProperty('PUBLIC');
        $this->behaviorable->setProtectedProperty('PROTECTED');
        $this->behaviorable->setPrivateProperty('PRIVATE');
        
        $this->assertEquals('behavior1: PUBLIC', $this->behaviorable->getPublicProperty());
        $this->assertEquals('behavior1: PROTECTED', $this->behaviorable->getProtectedProperty());
        $this->assertEquals(
            'Please use reflection to read privateProperty\'s value!', $this->behaviorable->getPrivateProperty()
        );
        $this->assertEquals('PRIVATE', $this->behaviorable->in('behavior2')->getPrivateProperty());
    }
    /*
    public function testDoesItExecuteExistingBehaviorMethodsWithoutExceptionWhenMethodIsNotRequired()
    {
        ob_start();
        $this->behaviorable->notRequiredCallback();
        $output = ob_get_clean();
        
        $expected = 'Behavior1::notRequiredCallback' . PHP_EOL . 'Behavior3::notRequiredCallback' . PHP_EOL;
        
        $this->assertEquals($expected, $output);
    }
    */
    public function testDoesItExecuteExistingBehaviorMethodsWhenThatsRequired()
    {
        $this->behaviorable->beforeSomething();
        
        $expected = array(
            0 => 'Behavior1',
            1 => 'Behavior2'
        );
        
        $this->assertEquals($expected, $this->behaviorable->getBeforeSomethings());
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException
     * @expectedExceptionMessage Ezt a behavior-t már használod! (behavior1)
     */
    public function testDoesItThrowExceptionWhenITryToFilterToSameBehaviorTwice()
    {
        $this->behaviorable->in('behavior1', 'behavior2', 'behavior1')->apple();
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException
     * @expectedExceptionMessage A behavior nincs definiálva! (undefinedBehavior)
     */
    public function testDoesItThrowExceptionWhenITryToAccessUndefinedBehavior()
    {
        $this->behaviorable->in('undefinedBehavior')->method1();
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException
     * @expectedExceptionMessage Nem található végrehajtható metódus! (undefinedBehaviorMethod)
     */
    public function testDoesItThrowExceptionWhenITryToCallAnUndefinedBehaviorMethod()
    {
        $this->behaviorable->undefinedBehaviorMethod();
    }
    
    public function setUp()
    {
        $this->behaviorable = new BehaviorableClass;
        $this->behaviorable->setBehaviorContainer(new \Uniweb\Library\Utilities\Behavior\BehaviorContainer());
        $this->behaviorable->attachBehavior('behavior1', new Behavior1);
        $this->behaviorable->attachBehavior('behavior2', new Behavior2);
        $this->behaviorable->attachBehavior('behavior3', new Behavior3);
    }
}