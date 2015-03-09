<?php
namespace Tests\Uniweb\Library\Utilities\Behavior;
use Tests\Uniweb\Library\Utilities\Behavior\Src\Behavior1;
use Tests\Uniweb\Library\Utilities\Behavior\Src\Behavior2;
use Uniweb\Library\Utilities\Behavior\BehaviorContainer;
use PHPUnit_Framework_TestCase;

class BehaviorContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Uniweb\Library\Utilities\Behavior\BehaviorContainer
     */
    protected $behaviorContainer;
    
    public function testDoesItCountCorrectly()
    {
        $this->assertEquals(0, count($this->behaviorContainer));
        $this->behaviorContainer->attachBehavior('behavior1', new Behavior1(new \stdClass));
        $this->behaviorContainer->attachBehavior('behavior2', new Behavior2(new \stdClass));
        $this->assertEquals(2, count($this->behaviorContainer));
        $this->behaviorContainer->detachBehavior('behavior1');
        $this->assertEquals(1, count($this->behaviorContainer));
    }
    
    public function testCanICheckExistenceOfBehaviorWhenIUseHasBehavior()
    {
        $this->assertFalse($this->behaviorContainer->hasBehavior('behavior1'));
        $this->behaviorContainer->attachBehavior('behavior1', new Behavior1(new \stdClass));
        $this->assertTrue($this->behaviorContainer->hasBehavior('behavior1'));
    }
    
    public function testCanIGetCorrectBehaviorWhenIUseGetBehavior()
    {
        $behavior = new Behavior1(new \stdClass);
        $this->behaviorContainer->attachBehavior('behavior1', $behavior);
        $this->assertTrue($this->behaviorContainer->hasBehavior('behavior1'));
        $gotBehavior = $this->behaviorContainer->getBehavior('behavior1');
        $this->assertInstanceOf('\\Uniweb\\Library\\Utilities\\Behavior\\Interfaces\\BehaviorInterface', $gotBehavior);
        $this->assertInstanceOf('\\Tests\\Uniweb\\Library\\Utilities\\Behavior\\Src\\Behavior1', $gotBehavior);
        $this->assertEquals($behavior, $gotBehavior);
    }
    
    public function testCanIAttachBehaviorsWhenIUseAttachBehavior()
    {
        $this->behaviorContainer->attachBehavior('behavior1', new Behavior1(new \stdClass));
        $this->behaviorContainer->attachBehavior('behavior2', new Behavior2(new \stdClass));
        $this->assertTrue($this->behaviorContainer->hasBehavior('behavior1'));
        $this->assertTrue($this->behaviorContainer->hasBehavior('behavior2'));
    }
    
    public function testCanIDetachExistingBehaviorWhenIUseDetachBehavior()
    {
        $this->behaviorContainer->attachBehavior('behavior1', new Behavior1(new \stdClass));
        $this->assertTrue($this->behaviorContainer->hasBehavior('behavior1'));
        $this->behaviorContainer->detachBehavior('behavior1');
        $this->assertFalse($this->behaviorContainer->hasBehavior('behavior1'));
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     * @expectedExceptionMessage A keresett behavior (behavior1) nem létezik!
     */
    public function testCanIGetAnExceptionWhenITryToGetNonExistingBehaviorWhenIUseGetBehavior()
    {
        $this->behaviorContainer->getBehavior('behavior1');
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     * @expectedExceptionMessage A/az (behavior1) nevű behavior már létezik!
     */
    public function testCanIGetAnExceptionWhenITryToOverrideExistingBehaviorWhenIUseAttachBehavior()
    {
        $this->behaviorContainer->attachBehavior('behavior1', new Behavior1(new \stdClass));
        $this->behaviorContainer->attachBehavior('behavior1', new Behavior1(new \stdClass));
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     * @expectedExceptionMessage A keresett behavior (behavior1) nem létezik!
     */
    public function testCanIGetAnExceptionWhenITryDetachNonExistingBehaviorWhenIUseAttachBehavior()
    {
        $this->behaviorContainer->detachBehavior('behavior1');
    }
    
    public function testCanICheckBehaviorExistenceWithIsset()
    {
        $this->assertFalse(isset($this->behaviorContainer['behavior1']));
        $this->behaviorContainer['behavior1'] = new Behavior1(new \stdClass);
        $this->assertTrue(isset($this->behaviorContainer['behavior1']));
    }
    
    public function testCanIGetCorrectBehaviorWhenIUseCorrectOffset()
    {
        $behavior = new Behavior1(new \stdClass);
        $this->behaviorContainer['behavior1'] = $behavior;
        $gotBehavior = $this->behaviorContainer['behavior1'];
        $this->assertEquals($behavior, $gotBehavior);
    }
    
    public function testCanIPushANewBehaviorInstanceToTheContainerWhenIUseOffset()
    {
        $this->behaviorContainer['behavior1'] = new Behavior1(new \stdClass);
    }
    
    public function testCanIUnsetExistingBehavior()
    {
        $this->behaviorContainer['behavior1'] = new Behavior1(new \stdClass);
        $this->assertTrue(isset($this->behaviorContainer['behavior1']));
        unset($this->behaviorContainer['behavior1']);
        $this->assertFalse(isset($this->behaviorContainer['behavior1']));
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     * @expectedExceptionMessage A keresett behavior (behavior1) nem létezik!
     */
    public function testCanIGetAnExceptionWhenITryToGetANotExistingBehaviorAndIUseInvalidOffset()
    {
        $this->behaviorContainer['behavior1'];
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     * @expectedExceptionMessage A/az (behavior1) nevű behavior már létezik!
     */
    public function testCanIGetAnExceptionWhenITryToAttachAnExistingBehaviorWhenIUseOffset()
    {
        $this->behaviorContainer['behavior1'] = new Behavior1(new \stdClass);
        $this->behaviorContainer['behavior1'] = new Behavior1(new \stdClass);
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     * @expectedExceptionMessage A paraméterül adott érték nem Behavior objektum!
     */
    public function testCanIGetAnExceptionWhenITryToAttachAnInvalidBehaviorWhenIUseOffset()
    {
        $this->behaviorContainer['behavior1'] = true;
    }
    /**
     * @expectedException \Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     * @expectedExceptionMessage A keresett behavior (behavior1) nem létezik!
     */
    public function testCanIGetAnExceptionWhenITryToDetachANotExistingBehaviorWhenIUseOffset()
    {
        unset($this->behaviorContainer['behavior1']);
    }
    
    public function testCanIForeachBehaviorContainer()
    {
        $behaviors = array(
            'behavior1' => new Behavior1(new \stdClass),
            'behavior2' => new Behavior2(new \stdClass)
        );
        foreach ($behaviors as $alias => $behavior) {
            $this->behaviorContainer->attachBehavior($alias, $behavior);
        }
        foreach ($this->behaviorContainer as $behavior) {
            $this->assertInstanceOf('\\Uniweb\\Library\\Utilities\\Behavior\\Interfaces\\BehaviorInterface', $behavior);
        }
    }
    
    public function setUp()
    {
        $this->behaviorContainer = new BehaviorContainer;
    }
}