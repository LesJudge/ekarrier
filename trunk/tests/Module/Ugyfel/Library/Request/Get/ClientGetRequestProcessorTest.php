<?php
use Uniweb\Module\Ugyfel\Library\Request\Get\Processor;

class ClientGetRequestProcessorTest extends PHPUnit_Framework_TestCase
{
    protected $processor;
    
    /**
     * @dataProvider dataProvider
     */
    public function testDoesItProcessCorrectly($data)
    {
        $processed = $this->processor->process($data);
        $this->assertEquals($data, $processed);
    }
    
    public function dataProvider()
    {
        $requestStd = new stdClass;
        $requestStd->id = 1;
        return array(
            array(
                array(
                    'GET' => array(
                        'id' => 1
                    )
                )
            ),
            array(
                new stdClass
            ),
            array(
                $requestStd
            )
        );
    }
    
    public function setUp()
    {
        $this->processor = new Processor;
    }
}