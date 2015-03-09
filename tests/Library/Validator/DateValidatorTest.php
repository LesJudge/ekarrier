<?php
namespace Tests\Uniweb\Library\Validator;
use Uniweb\Library\Validator\Date;
use PHPUnit_Framework_TestCase;
use stdClass;

class DateValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testDoesItValidateCorrectly($value, $format, $expected)
    {
        $dateValidator = new Date;
        $dateValidator->setFormat($format);
        $this->assertEquals($expected, $dateValidator->validate($value));
    }
    
    public function dataProvider()
    {
        return array(
            array('2014-10-17', 'Y-m-d', true),
            array(1, 'Y-m-d', false),
            array(2000, 'Y', true),
            array('2000', 'Y', true),
            array('20:00:00', 'H:i:s', true),
            array('2014-02-31', 'Y-m-d', false),
            array('2014-02-28', 'Y-m-d', true),
            array(null, 'Y', false),
            array('string', 'Y', false),
            array(new stdClass, 'Y-m-d', false),
            array(new stdClass, 'Y', false),
            array(array(), 'Y', false),
            array(2000.5, 'Y', false)
        );
    }
}