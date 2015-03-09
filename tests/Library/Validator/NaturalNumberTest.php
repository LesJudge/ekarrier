<?php
namespace Tests\Uniweb\Library\Validator;
use PHPUnit_Framework_TestCase;
use Uniweb\Library\Validator\NaturalNumber;

class NaturalNumberTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testDoesItValidateCorrectly($value, $zeroIsNatural, $expected)
    {
        $naturalNumberValidator = new NaturalNumber;
        if ($zeroIsNatural === true) {
            $naturalNumberValidator->setZeroIsNatural(true);
        }
        $this->assertEquals($expected, $naturalNumberValidator->validate($value));
    }
    
    public function dataProvider()
    {
        return array(
            array(0, false, false),
            array(-1, true, false),
            array(8, true, true),
            array(0, true, true),
            array(1, false, true),
            array(2, true, true),
            array(2, false, true),
            array(2.45, true, false),
            array(2.45, false, false),
            array('2.45', false, false),
            array('2.45', true, false)
        );
    }
}