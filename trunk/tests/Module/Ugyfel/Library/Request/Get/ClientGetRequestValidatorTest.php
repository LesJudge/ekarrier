<?php
use Uniweb\Module\Ugyfel\Library\Request\Get\Validator;

class ClientGetRequestValidatorTest extends PHPUnit_Framework_TestCase
{
    protected $validator;
    /**
     * @dataProvider validProvider
     */
    public function testDoesItPassOnValidData($data)
    {
        $this->assertTrue($this->validator->validate($data));
    }
    /**
     * @dataProvider invalidProvider
     * @expectedException Uniweb\Library\Utilities\Request\Exception\ValidateException
     */
    public function testDoesItFailOnInvalidData($data)
    {
        $this->validator->validate($data);
    }
    
    public function validProvider()
    {
        return array(
            array(
                // Teljesen új ügyfél.
                array(
                    'GET' => array(
                        'id' => null
                    )
                )
            ),
            array(
                // Meglévő ügyfél.
                array(
                    'GET' => array(
                        'id' => 1
                    )
                )
            ),
            array(
                // Teljesen új ügyfél egyéb adatokkal.
                array(
                    'GET' => array(
                        'id' => '',
                        'foo' => 'bar',
                        'baz' => 'bar'
                    )
                )
            ),
            array(
                // Meglévő ügyfél egyéb adatokkal.
                array(
                    'GET' => array(
                        'id' => 'z',
                        'foo' => 'bar',
                        'baz' => 'bar'
                    )
                )
            )
        );
    }
    
    public function invalidProvider()
    {
        return array(
            array(
                array(
                    'GET' => array(
                        
                    )
                )
            ),
            array(
                array(
                    'GET' => array(
                        'foo' => 'bar'
                    )
                )
            )
        );
    }
    
    public function setUp()
    {
        $this->validator = new Validator;
    }
}