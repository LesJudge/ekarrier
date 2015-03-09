<?php
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior\ActiveRecordBehaviorTestCase;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Src\CompleteModel;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Author;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\NumberOfModifications;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Timestamp;
use Uniweb\Library\Utilities\ActiveRecord\SheepIt\JsonSerializeModel;

class JsonSerializeModelTest extends ActiveRecordBehaviorTestCase
{
    public function testSerializeDefaultAttributes()
    {
        $model1 = new CompleteModel;
        $model1->attachBehavior('author', new Author('creator', 'modificatory'));
        $model1->attachBehavior('nom', new NumberOfModifications('nom'));
        $model1->attachBehavior('status', new RecordStatus('active', 'deleted'));
        $model1->attachBehavior('timestamp', new Timestamp('created', 'modified'));
        $model1->id = 1;
        $model1->value = 'Value';
        $model1->letrehozas_timestamp = '2015-01-29 22:00:00';
        $model1->modositas_timestamp = 'string';
        $model1->is_valid();
        
        $jsonSerializeModel = new JsonSerializeModel($model1, 'prefix');
        $processed1 = $jsonSerializeModel->jsonSerialize();
        $processed2 = (array)json_decode(\Uniweb\Functions\uniweb_json_encode($jsonSerializeModel));
        
        $this->checkAttributesExistence($processed1, array_keys($model1->attributes()), 'prefix');
        $this->checkAttributesExistence($processed2, array_keys($model1->attributes()), 'prefix');
    }
    
    public function testDefinedAttributes()
    {
        $model1 = new CompleteModel;
        $model1->attachBehavior('author', new Author('creator', 'modificatory'));
        $model1->attachBehavior('nom', new NumberOfModifications('nom'));
        $model1->attachBehavior('status', new RecordStatus('active', 'deleted'));
        $model1->attachBehavior('timestamp', new Timestamp('created', 'modified'));
        $model1->id = 1;
        $model1->value = 'MyValue';
        $model1->letrehozo_id = new \stdClass;
        $model1->modosito_id = 'string';
        $model1->is_valid();
        
        $jsonSerializeModel = new JsonSerializeModel(
            $model1, 'prefix', array('id', 'value', 'creator', 'modosito_id')
        );
        $processed1 = $jsonSerializeModel->jsonSerialize();
        $processed2 = (array)  json_decode(\Uniweb\Functions\uniweb_json_encode($jsonSerializeModel));
        
        $this->checkAttributesExistence($processed1, array('id', 'value', 'creator', 'modosito_id'), 'prefix');
        $this->checkAttributesExistence($processed2, array('id', 'value', 'creator', 'modosito_id'), 'prefix');
        $this->assertCount(8, $processed1);
        $this->assertCount(8, $processed2);
        $this->assertEquals(1, $processed1['prefix_id']);
        $this->assertEquals('', $processed1['prefix_id_error']);
        $this->assertEquals('MyValue', $processed1['prefix_value']);
        $this->assertEquals('', $processed1['prefix_value_error']);
        $this->assertEquals('{}', $processed1['prefix_creator']);
        $this->assertEquals('A létrehozó felhasználó azonosítója nem megfelelő!', $processed1['prefix_creator_error']);
        $this->assertEquals(1, $processed2['prefix_id']);
        $this->assertEquals('', $processed2['prefix_id_error']);
        $this->assertEquals('MyValue', $processed2['prefix_value']);
        $this->assertEquals('', $processed2['prefix_value_error']);
        $this->assertEquals('{}', $processed2['prefix_creator']);
        $this->assertEquals('A létrehozó felhasználó azonosítója nem megfelelő!', $processed2['prefix_creator_error']);
    }
    
    protected function checkAttributesExistence($processed, $attributes, $prefix = '')
    {
        $prefix = $prefix == '' ? $prefix : $prefix . '_';
        foreach ($attributes as $attribute) {
            $this->assertArrayHasKey($prefix . $attribute, $processed);
            $this->assertArrayHasKey($prefix . $attribute . '_error', $processed);
        }
    }
    
    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet();
    }
}