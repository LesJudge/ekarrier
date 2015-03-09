<?php
namespace Tests\Uniweb\Library\Validator;
use PHPUnit_Framework_TestCase;
use Uniweb\Library\Validator\EmptyArray;
use stdClass;

class EmptyArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testDoesItValidateCorrectly($value, $expected)
    {
        $emptyArrayValidator = new EmptyArray;
        $this->assertEquals($expected, $emptyArrayValidator->validate($value));
    }
    
    public function dataProvider()
    {
        return array(
            array(
                array(),
                true
            ),
            array(
                array(
                    'foo' => 'bar',
                    'baz' => 'bar'
                ),
                false
            ),
            array(
                1,
                false
            ),
            array(
                range(1, 10),
                false
            ),
            array(
                new stdClass,
                false
            ),
            array(
                array(null),
                false
            )
        );
    }
}