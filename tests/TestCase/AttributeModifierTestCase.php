<?php
namespace Tests\Uniweb\TestCase;
use PHPUnit_Framework_TestCase;

abstract class AttributeModifierTestCase extends PHPUnit_Framework_TestCase
{
    protected $attributeModifier;
    
    /**
     * @dataProvider dataProvider
     */
    public function testDoesModifyAttributesCorrectly($attributes, $expected)
    {
        $this->attributeModifier->modifyAttributes($attributes);
        $this->assertEquals($expected, $attributes);
    }
    
    protected function setUp()
    {
        $this->attributeModifier = $this->modifierInstance();
    }
    
    abstract public function dataProvider();
    
    abstract public function modifierInstance();
}