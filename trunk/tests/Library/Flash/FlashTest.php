<?php
namespace Tests\Uniweb\Library\Flash;
use PHPUnit_Framework_TestCase;
use Uniweb\Library\Flash\Flash;
use Uniweb\Library\Flash\Interfaces\FlashInterface;
use ReflectionMethod;

class FlashTest extends PHPUnit_Framework_TestCase
{
    protected $flash;
    
    /**
     * @dataProvider keysProvider
     */
    public function testAcceptsOnlyValidKeys($key, $expected)
    {
        $data = array();
        $method = new ReflectionMethod('Uniweb\\Library\\Flash\\Flash', 'validateFlashId');
        $method->setAccessible(true);
        $this->assertEquals($expected, $method->invoke(new Flash($data, $this->flash->getKey()), $key));
    }
    
    public function keysProvider()
    {
        return array(
            array('abc', true),
            array('abc123', true),
            array('a1b2c3', true),
            array('éáöoi321', false),
            array('@éiö9128', false)
        );
    }
    
    public function testFlashKeyIsCorrect()
    {
        $this->assertEquals('testKey', $this->flash->getKey());
        return $this->flash;
    }
    /**
     * @depends testFlashKeyIsCorrect
     */
    public function testHasNotFlash(FlashInterface $flash)
    {
        $this->assertEquals(false, $flash->hasFlash('testId'));
        return $flash;
    }
    /**
     * @depends testHasNotFlash
     */
    public function testHasFlash(FlashInterface $flash)
    {
        $flash->setFlash('testFlash', 'testFlash');
        $this->assertEquals(true, $flash->hasFlash('testFlash'));
        return $flash;
    }
    /**
     * @depends testHasFlash
     */
    public function testReturnsCorrectValueOnExistingFlash(FlashInterface $flash)
    {
        $this->assertEquals('testFlash', $flash->getFlash('testFlash'));
        return $flash;
    }
    /**
     * @depends testReturnsCorrectValueOnExistingFlash
     */
    public function testDoesOverrideExistingFlashValueOnTrueOverride(FlashInterface $flash)
    {
        $flash->setFlash('testFlash', 'override', true);
        $this->assertNotEquals('testFlash', $flash->getFlash('testFlash'));
        return $flash;
    }
    /**
     * @depends testDoesOverrideExistingFlashValueOnTrueOverride
     */
    public function testDoesNotOverrideExistingFlashOnFalseOverride(FlashInterface $flash)
    {
        $flash->setFlash('testFlash', 'testFlash');
        $this->assertEquals('override', 'override');
        return $flash;
    }
    /**
     * @depends testDoesNotOverrideExistingFlashOnFalseOverride
     */
    public function testRemoveFlash(FlashInterface $flash)
    {
        $flash->removeFlash('testFlash');
        $this->assertEquals(false, $flash->hasFlash('testFlash'));
    }
    
    public function setUp()
    {
        $data = array();
        $flash = new Flash($data, 'testKey');
        $this->flash = $flash;
    }
}