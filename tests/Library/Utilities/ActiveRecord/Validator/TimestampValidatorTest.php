<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Validator;
use PHPUnit_Framework_TestCase;

class TimestampValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * 
     * @param type $value
     * @param type $allowNull
     * @param type $expected
     * @dataProvider dataProvider
     */
    public function testDoesItValidateCorrectly($value, $allowNull, $expected)
    {
        $validator = new \Uniweb\Library\Utilities\ActiveRecord\Validator\Timestamp(false);
        if ($allowNull == true) {
            $validator->setAllowNull(true);
        }
        $this->assertEquals($expected, $validator->validate($value));
    }
    
    public function dataProvider()
    {
        return array(
            array(new \ActiveRecord\DateTime('2015-01-20 08:00:00', null), false, true),
            array(array(), true, false),
            array(array(), false, false),
            array(new \stdClass, true, false),
            array(new \stdClass, false, false),
            array(1, true, false),
            array(1, false, false),
            array('string', true, false),
            array('string', false, false),
            array('2015-01-20', true, false),
            array('2015-01-20', false, false),
            array(null, false, false),
            array(null, true, true)
        );
    }
}