<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Validator;
use PHPUnit_Framework_TestCase;

class ForeignKeyValidatorTest extends PHPUnit_Framework_TestCase
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
        $validator = new \Uniweb\Library\Utilities\ActiveRecord\Validator\ForeignKey(false);
        if ($allowNull == true) {
            $validator->setAllowNull(true);
        }
        $this->assertEquals($expected, $validator->validate($value));
    }
    
    public function dataProvider()
    {
        return array(
            array(1, true, true),
            array(2, false, true),
            array(-1, true, false),
            array('string', true, false),
            array(new \stdClass, true, false),
            array(1, true, true),
            array(null, true, true),
            array(null, false, false),
            array(true, true, false),
            array(false, false, false),
            array(array(), true, false)
        );
    }
}