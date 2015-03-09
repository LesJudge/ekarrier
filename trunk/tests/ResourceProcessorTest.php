<?php
use Uniweb\Library\Resource\ResourceProcessor;

class ResourceProcessorTest extends PHPUnit_Framework_TestCase
{
    public function testDoesItProcessCorrectly()
    {
        $resourceProcessor = new ResourceProcessor;
        $processed = $resourceProcessor->process($this->data());
        
        $this->assertArrayHasKey('POST', $processed);
        
        $post = $processed['POST'];
        
        $this->assertArrayHasKey('Model', $post);
        $this->assertArrayHasKey('SheepIt', $post);
        $this->assertCount(1, $post['Model']);
        $this->assertCount(2, $post['SheepIt']);
        
        $model = $post['Model'];
        $sheepIt = $post['SheepIt'];
        
        $this->assertArrayHasKey('\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\TestModel', $model);
        $this->assertArrayHasKey('A\\Relative\\Namespaced\\Model', $sheepIt);
        $this->assertArrayHasKey('\\A\\Fully\\Namespaced\\Model', $sheepIt);
    }
    
    public function data()
    {
        return array(
            'POST' => array(
                'Model' => array(
                    '.Uniweb.Module.Ugyfel.Model.ActiveRecord.TestModel' => array(
                        'test' => 'value'
                    )
                ),
                'SheepIt' => array(
                    'A.Relative.Namespaced.Model' => array(
                        0 => array(
                            'foo' => 'bar'
                        ),
                        1 => array(
                            'baz' => 'bar'
                        )
                    ),
                    '.A.Fully.Namespaced.Model' => array(
                        0 => array(
                            'value' => 'test'
                        )
                    )
                )
            )
        );
    }
}