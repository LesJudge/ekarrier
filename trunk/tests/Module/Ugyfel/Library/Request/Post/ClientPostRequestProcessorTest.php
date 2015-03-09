<?php
use Uniweb\Module\Ugyfel\Library\Request\Post\Processor;

class ClientPostRequestProcessorTest extends PHPUnit_Framework_TestCase
{
    protected $processor;
    /**
     * @dataProvider dataProvider
     */
    public function testDoesItProcessCorrectly($processed, $data)
    {
        $this->assertEquals($processed, $this->processor->process($data));
    }
    
    public function dataProvider()
    {
        return array(
            array(
                array(
                    'POST' => array(
                        'Model' => array(
                            '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\ClientBirthData' => array(
                                'foo' => 'bar',
                                'baz' => 'bar'
                            )
                        )
                    )
                ),
                array(
                    'POST' => array(
                        'Model' => array(
                            '.Uniweb.Module.Ugyfel.Model.ActiveRecord.ClientBirthData' => array(
                                'foo' => 'bar',
                                'baz' => 'bar'
                            )
                        )
                    )
                )
            ),
            array(
                array(
                    'POST' => array(
                        'SheepIt' => array(
                            '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\Education' => array(
                                0 => array(
                                    'foo' => 'bar',
                                    'baz' => 'bar'
                                )
                            )
                        )
                    )
                ),
                array(
                    'POST' => array(
                        'SheepIt' => array(
                            '.Uniweb.Module.Ugyfel.Model.ActiveRecord.Education' => array(
                                0 => array(
                                    'foo' => 'bar',
                                    'baz' => 'bar'
                                )
                            )
                        )
                    )
                )
            )
        );
    }
    
    protected function setUp()
    {
        $this->processor = new Processor;
    }
}