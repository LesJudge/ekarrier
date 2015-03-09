<?php
use Uniweb\Module\Ugyfel\Library\Request\Post\Validator;

class ClientPostRequestValidatorTest extends PHPUnit_Framework_TestCase
{
    protected $validator;
    
    /**
     * 
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
                        'id' => ''
                    ),
                    'POST' => array(
                        'resource' => array(
                            'foo' => 'bar',
                            'baz' => 'bar'
                        )
                    )
                ),
                // Teljesen új ügyfél egyéb adatokkal.
                array(
                    'GET' => array(
                        'id' => null
                    ),
                    'POST' => array(
                        'resource' => array(
                            'foo' => 'bar',
                            'baz' => 'bar'
                        ),
                        'Model' => array(
                            '.Uniweb.Module.Ugyfel.Model.ActiveRecord.LaborMarket' => array(
                                'property' => 'value'
                            )
                        )
                    )
                )
            ),
            // Meglévő ügyfél.
            array(
                array(
                    'GET' => array(
                        'id' => 1
                    ),
                    'POST' => array(
                        'resource' => array(
                            'foo' => 'bar',
                            'baz' => 'bar'
                        )
                    )
                )
            ),
            // Meglévő ügyfél egyéb adatokkal.
            array(
                array(
                    'GET' => array(
                        'id' => 1
                    ),
                    'POST' => array(
                        'resource' => array(
                            'foo' => 'bar',
                            'baz' => 'bar'
                        ),
                        'Model' => array(
                            '.Uniweb.Module.Ugyfel.Model.ActiveRecord.LaborMarket' => array(
                                'property' => 'value'
                            )
                        )
                    )
                )
            )
        );
    }
    
    public function invalidProvider()
    {
        return array(
            // Teljesen új ügyfél, hiányzó resource index-szel.
            array(
                array(
                    'GET' => array(
                        'id' => null
                    ),
                    'POST' => array()
                )
            ),
            // Teljesen új ügyfél, üres resource tömbbel.
            array(
                array(
                    'GET' => array(
                        'id' => null,
                    ),
                    'POST' => array(
                        'resource' => array()
                    )
                )
            ),
            // Meglévő ügyfél hiányzó resource index-szel.
            array(
                array(
                    'GET' => array(
                        'id' => 1
                    ),
                    'POST' => array()
                )
            ),
            // Meglévő ügyfél, üres resource tömbbel.
            array(
                array(
                    'GET' => array(
                        'id' => 1
                    ),
                    'POST' => array(
                        'resource' => array()
                    )
                )
            ),
            // Meglévő ügyfél, üres resource tömbbel, egyéb adatokkal.
            array(
                array(
                    'GET' => array(
                        'id' => 1
                    ),
                    'POST' => array(
                        'resource' => array(),
                        'Model' => array(
                            '.Uniweb.Module.Ugyfel.Model.ActiveRecord.LaborMarket' => array(
                                'property' => 'value'
                            )
                        )
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