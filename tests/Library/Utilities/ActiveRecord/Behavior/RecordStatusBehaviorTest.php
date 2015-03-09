<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior\ActiveRecordBehaviorTestCase;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Src\CompleteModel;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus;

class RecordStatusBehaviorTest extends ActiveRecordBehaviorTestCase
{
    public function testDoesGetterSetterWorkCorrectlyWhenAllAttributesAreDefined()
    {
        $model = $this->createModel();
        
        $this->assertEquals(1, $model->aktiv);
        $this->assertEquals(1, $model->get_aktiv());
        $this->assertEquals(1, $model->in('status')->get_aktiv());
        $this->assertEquals(0, $model->torolt);
        $this->assertEquals(0, $model->get_torolt());
        $this->assertEquals(0, $model->in('status')->get_torolt());
        
        $model->aktiv = 10;
        
        $this->assertEquals(10, $model->aktiv);
        $this->assertEquals(10, $model->get_aktiv());
        $this->assertEquals(10, $model->in('status')->get_aktiv());
        
        $model->set_aktiv(false);
        
        $this->assertEquals(false, $model->aktiv);
        $this->assertEquals(false, $model->get_aktiv());
        $this->assertEquals(false, $model->in('status')->get_aktiv());
        
        $model->in('status')->set_aktiv(array());
        
        $this->assertEquals(array(), $model->aktiv);
        $this->assertEquals(array(), $model->get_aktiv());
        $this->assertEquals(array(), $model->in('status')->get_aktiv());
        
        $model->torolt = array(array());
        
        $this->assertEquals(array(), $model->torolt);
        $this->assertEquals(array(), $model->get_torolt());
        $this->assertEquals(array(), $model->in('status')->get_torolt());
        
        $stdClass = new \stdClass;
        $model->set_torolt($stdClass);
        
        $this->assertEquals($stdClass, $model->torolt);
        $this->assertEquals($stdClass, $model->get_torolt());
        $this->assertEquals($stdClass, $model->in('status')->get_torolt());
        
        $model->in('status')->set_torolt(null);
        
        $this->assertEquals(null, $model->torolt);
        $this->assertEquals(null, $model->get_torolt());
        $this->assertEquals(null, $model->in('status')->get_torolt());
    }
    
    public function testDoesGetterSetterWorkCorrectlyWhenOnlyActiveIsDefined()
    {
        $model = $this->createActiveOnlyModel();
        
        $this->assertEquals(1, $model->aktiv);
        $this->assertEquals(1, $model->get_aktiv());
        $this->assertEquals(1, $model->in('status')->get_aktiv());
        $this->assertTrue($this->catchException(function() use ($model) { $model->torolt; }));
        $this->assertTrue($this->catchException(function() use ($model) { $model->get_torolt(); }));
        $this->assertTrue($this->catchException(function() use ($model) { $model->in('status')->get_torolt(); }));
        
        $model->aktiv = array(array());
        
        $this->assertEquals(array(), $model->aktiv);
        $this->assertEquals(array(), $model->get_aktiv());
        $this->assertEquals(array(), $model->in('status')->get_aktiv());
        
        $model->set_aktiv(false);
        
        $this->assertEquals(false, $model->aktiv);
        $this->assertEquals(false, $model->get_aktiv());
        $this->assertEquals(false, $model->in('status')->get_aktiv());
        
        $stdClass = new \stdClass;
        $model->in('status')->set_aktiv($stdClass);
        $this->assertEquals($stdClass, $model->aktiv);
        $this->assertEquals($stdClass, $model->get_aktiv());
        $this->assertEquals($stdClass, $model->in('status')->get_aktiv());
    }
    
    public function testDoesGetterSetterWorkCorrectlyWhenOnlyDeletedIsDefined()
    {
        $model = $this->createDeleteOnlyModel();
        
        $this->assertEquals(0, $model->torolt);
        $this->assertEquals(0, $model->get_torolt());
        $this->assertEquals(0, $model->in('status')->get_torolt());
        $this->assertTrue($this->catchException(function() use ($model) { $model->aktiv; }));
        $this->assertTrue($this->catchException(function() use ($model) { $model->get_aktiv(); }));
        $this->assertTrue($this->catchException(function() use ($model) { $model->in('status')->get_aktiv(); }));
        
        $model->torolt = null;
        
        $this->assertEquals(null, $model->torolt);
        $this->assertEquals(null, $model->get_torolt());
        $this->assertEquals(null, $model->in('status')->get_torolt());
        
        $model->set_torolt(1.67);
        
        $this->assertEquals(1.67, $model->torolt);
        $this->assertEquals(1.67, $model->get_torolt());
        $this->assertEquals(1.67, $model->in('status')->get_torolt());
        
        $model->in('status')->set_torolt('$stdClass');
        $this->assertEquals('$stdClass', $model->torolt);
        $this->assertEquals('$stdClass', $model->get_torolt());
        $this->assertEquals('$stdClass', $model->in('status')->get_torolt());
    }
    
    public function testDoesItValidateCorrectlyWhenAllAttributesAreDefined()
    {
        $model = $this->createModel();
        $model->value = 'Value';
        
        $this->assertTrue($model->is_valid());
        
        $model->aktiv = 1;
        $model->torolt = 1;
        
        $this->assertTrue($model->is_valid());
        
        $model->aktiv = 2;
        $model->torolt = 3;
        
        $this->assertFalse($model->is_valid());
        
        $errors = $model->errors->to_array();
        
        $this->assertArrayHasKey('active', $errors);
        $this->assertArrayHasKey('deleted', $errors);
        $this->assertEquals('Az aktív mező értéke nem megfelelő! (0-1)', $model->errors->on('active'));
        $this->assertEquals('A törölt mező értéke nem megfelelő! (0-1)', $model->errors->on('deleted'));
        $this->assertCount(2, $errors);
        
        $model->torolt = null;
        
        $this->assertFalse($model->is_valid());
        
        $errors = $model->errors->to_array();
        
        $this->assertArrayHasKey('active', $errors);
        $this->assertCount(1, $errors);
        
        $model->aktiv = 1;
        
        $this->assertTrue($model->is_valid());
        
        $errors = $model->errors->to_array();
        
        $this->assertCount(0, $errors);
    }
    
    public function testDoesItValidateCorrectlyWhenOnlyActiveIsDefined()
    {
        $model = $this->createActiveOnlyModel();
        $model->value = 'Value';
        
        $this->assertTrue($model->is_valid());
        $this->assertTrue($this->catchException(function() use ($model) { $model->torolt; }));
        
        $model->aktiv = 100;
        
        $this->assertFalse($model->is_valid());
        
        $errors = $model->errors->to_array();
        
        $this->assertArrayHasKey('active', $errors);
        $this->assertEquals('Az aktív mező értéke nem megfelelő! (0-1)', $model->errors->on('active'));
        $this->assertCount(1, $errors);
        
        $model->aktiv = 0;
        
        $this->assertTrue($model->is_valid());
        $this->assertCount(0, $model->errors->to_array());
    }
    
    public function testDoesCrudWorkCorrectlyWhenAllAttributesAreDefined()
    {
        $model1 = $this->createModel();
        $model1->value = 'Value';
        
        /* @var $behavior \Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus */
        $behavior = $model1->getBehaviorContainer()->getBehavior('status');
        
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals($behavior->getDefaultActive(), $model1->aktiv);
        $this->assertEquals($behavior->getDefaultDeleted(), $model1->torolt);
        
        /* @var $model2 CompleteModel */
        $model2 = CompleteModel::find(1);
        $model2->attachBehavior('status', new RecordStatus('active', 'deleted', 1, 0));
        $model2->value = 'New Value';
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals($behavior->getDefaultActive(), $model2->aktiv);
        $this->assertEquals($behavior->getDefaultDeleted(), $model2->torolt);
        
        $model2->aktiv = 0;
        $model2->torolt = 0;
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        
        $model3 = $this->createModel();
        $model3->value = 'some string';
        $model3->aktiv = 0;
        $model3->torolt = 1;
        
        $this->assertTrue($model3->save());
        $this->assertEquals(2, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertTrue($model1->delete());
        $this->assertTrue($model2->delete());
        $this->assertTrue($model3->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
    }
    
    public function testDoesCrudWorkCorrectlyWhenOnlyActiveDefined()
    {
        $model1 = $this->createActiveOnlyModel();
        $model1->value = 'save me';
        
        /* @var $behavior \Uniweb\Library\Utilities\ActiveRecord\Behavior\RecordStatus */
        $behavior = $model1->getBehaviorContainer()->getBehavior('status');
        
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals($behavior->getDefaultActive(), $model1->aktiv);
        
        /* @var $model2 CompleteModel */
        $model2 = CompleteModel::find(1);
        $model2->attachBehavior('status', new RecordStatus('active', null, 1, null));
        $model2->value = 'new';
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals($behavior->getDefaultActive(), $model2->aktiv);
        
        $model2->aktiv = 0;
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(0, $model2->aktiv);
        
        $model3 = $this->createActiveOnlyModel();
        $model3->value = 'value';
        $model3->aktiv = 0;
        
        $this->assertTrue($model3->save());
        $this->assertEquals(2, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(0, $model3->aktiv);
        $this->assertTrue($model1->delete());
        $this->assertTrue($model2->delete());
        $this->assertTrue($model3->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
    }
    
    public function testDoesCrudWorkCorrectlyWhenOnlyDeletedDefined()
    {
        $model1 = $this->createDeleteOnlyModel();
        $model1->value = 'save me';
        
        /* @var $behavior \Uniweb\Library\Utilities\DeleteRecord\Behavior\RecordStatus */
        $behavior = $model1->getBehaviorContainer()->getBehavior('status');
        
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals($behavior->getDefaultDeleted(), $model1->torolt);
        
        /* @var $model2 CompleteModel */
        $model2 = CompleteModel::find(1);
        $model2->attachBehavior('status', new RecordStatus(null, 'deleted', null, 0));
        $model2->value = 'new';
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals($behavior->getDefaultDeleted(), $model2->torolt);
        
        $model2->torolt = 0;
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(0, $model2->torolt);
        
        $model3 = $this->createDeleteOnlyModel();
        $model3->value = 'value';
        $model3->torolt = 0;
        
        $this->assertTrue($model3->save());
        $this->assertEquals(2, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(0, $model3->torolt);
        $this->assertTrue($model1->delete());
        $this->assertTrue($model2->delete());
        $this->assertTrue($model3->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
    }
    
    protected function catchException($callback)
    {
        $caughtException = false;
        try {
            call_user_func($callback);
        } catch (\ActiveRecord\UndefinedPropertyException $upe) {
            $caughtException = true;
        }
        return $caughtException;
    }
    
    protected function createDeleteOnlyModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('status', new RecordStatus(null, 'deleted', 1, 0));
        return $model;
    }
    
    protected function createActiveOnlyModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('status', new RecordStatus('active', null, 1, 0));
        return $model;        
    }
    
    protected function createModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('status', new RecordStatus('active', 'deleted', 1, 0));
        return $model;
    }
}