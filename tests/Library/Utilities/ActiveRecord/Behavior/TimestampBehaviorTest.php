<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior\ActiveRecordBehaviorTestCase;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Src\CompleteModel;
use Uniweb\Library\Utilities\Behavior\BehaviorContainer;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Timestamp;

class TimestampBehaviorTest extends ActiveRecordBehaviorTestCase
{
    public function testDoesGetterSetterWorksCorrectlyWhenAllAttributesDefined()
    {
        $model = $this->createModel();
        
        $this->assertNull($model->letrehozas_timestamp);
        $this->assertNull($model->modositas_timestamp);
        $this->assertNull($model->get_letrehozas_timestamp());
        $this->assertNull($model->get_modositas_timestamp());
        $this->assertNull($model->in('timestamp')->get_letrehozas_timestamp());
        $this->assertNull($model->in('timestamp')->get_modositas_timestamp());
        
        $model->letrehozas_timestamp = '2015-01-19 11:00:00';
        
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->letrehozas_timestamp);
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->get_letrehozas_timestamp());
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->in('timestamp')->get_letrehozas_timestamp());
        $this->assertEquals('2015-01-19 11:00:00', $model->letrehozas_timestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('2015-01-19 11:00:00', $model->get_letrehozas_timestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals(
            '2015-01-19 11:00:00', $model->in('timestamp')->get_letrehozas_timestamp()->format('Y-m-d H:i:s')
        );
        
        $model->set_letrehozas_timestamp('2015-01-19 11:05:00');
        
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->letrehozas_timestamp);
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->get_letrehozas_timestamp());
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->in('timestamp')->get_letrehozas_timestamp());
        $this->assertEquals('2015-01-19 11:05:00', $model->letrehozas_timestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('2015-01-19 11:05:00', $model->get_letrehozas_timestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals(
            '2015-01-19 11:05:00', $model->in('timestamp')->get_letrehozas_timestamp()->format('Y-m-d H:i:s')
        );
        
        $model->in('timestamp')->set_letrehozas_timestamp('2015-01-19 11:10:00');
        
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->letrehozas_timestamp);
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->get_letrehozas_timestamp());
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->in('timestamp')->get_letrehozas_timestamp());
        $this->assertEquals('2015-01-19 11:10:00', $model->letrehozas_timestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('2015-01-19 11:10:00', $model->get_letrehozas_timestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals(
            '2015-01-19 11:10:00', $model->in('timestamp')->get_letrehozas_timestamp()->format('Y-m-d H:i:s')
        );
        
        $model->modositas_timestamp = '2015-01-19 11:15:00';
        
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->modositas_timestamp);
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->get_modositas_timestamp());
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->in('timestamp')->get_modositas_timestamp());
        $this->assertEquals('2015-01-19 11:15:00', $model->modositas_timestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('2015-01-19 11:15:00', $model->get_modositas_timestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals(
            '2015-01-19 11:15:00', $model->in('timestamp')->get_modositas_timestamp()->format('Y-m-d H:i:s')
        );
        
        $model->set_modositas_timestamp('2015-01-19 11:20:00');
        
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->modositas_timestamp);
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->get_modositas_timestamp());
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->in('timestamp')->get_modositas_timestamp());
        $this->assertEquals('2015-01-19 11:20:00', $model->modositas_timestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('2015-01-19 11:20:00', $model->get_modositas_timestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals(
            '2015-01-19 11:20:00', $model->in('timestamp')->get_modositas_timestamp()->format('Y-m-d H:i:s')
        );
        
        $model->in('timestamp')->set_modositas_timestamp('2015-01-19 11:25:00');
        
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->modositas_timestamp);
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->get_modositas_timestamp());
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->in('timestamp')->get_modositas_timestamp());
        $this->assertEquals('2015-01-19 11:25:00', $model->modositas_timestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('2015-01-19 11:25:00', $model->get_modositas_timestamp()->format('Y-m-d H:i:s'));
        $this->assertEquals(
            '2015-01-19 11:25:00', $model->in('timestamp')->get_modositas_timestamp()->format('Y-m-d H:i:s')
        );
        
        $model->letrehozas_timestamp = array(array());
        
        $this->assertEquals(false, $model->letrehozas_timestamp);
        
        $model->letrehozas_timestamp = new \stdClass;
        
        $this->assertFalse($model->letrehozas_timestamp);
        
        $model->letrehozas_timestamp = 'string';
        
        $this->assertFalse($model->letrehozas_timestamp);
        
        $model->letrehozas_timestamp = '2015-01-19 01:10:19';
        
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->letrehozas_timestamp);
    }
    /**
     * @expectedException \ActiveRecord\UndefinedPropertyException
     * @expectedExceptionMessage timestamp
     */
    public function testDoesItThrowExceptionWhenITryToAccessUndefinedAttribute()
    {
        $model = $this->createCreatedOnlyModel();
        
        $model->letrehozas_timestamp = '2015-01-19 10:00:00';
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model->letrehozas_timestamp);
        $this->assertEquals('2015-01-19 10:00:00', $model->letrehozas_timestamp->format('Y-m-d H:i:s'));
        
        $this->assertNull($model->modositas_timestamp);
    }
    
    public function testDoesItValidateCorrectly()
    {
        $model1 = $this->createModel();
        
        $model1->letrehozas_timestamp = '2015-01-19 10:00:00';
        $model1->modositas_timestamp = null;
        
        $this->assertTrue($model1->is_valid());
        
        $errors = $model1->errors->to_array();
        
        $this->assertArrayNotHasKey('letrehozas_timestamp', $errors);
        $this->assertArrayNotHasKey('modositas_timestamp', $errors);
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        
        $model1->letrehozas_timestamp = new \stdClass;
        
        $this->assertFalse($model1->is_valid());
        
        $errors = $model1->errors->to_array();
        
        $this->assertArrayHasKey('created', $errors);
        $this->assertArrayNotHasKey('modified', $errors);
        $this->assertEquals('A létrehozás ideje nem megfelelő! (éééé-hh-nn óó:pp:mm)', $model1->errors->on('created'));
        
        $model1->modositas_timestamp = '2015';
        
        $this->assertFalse($model1->is_valid());
        
        $errors = $model1->errors->to_array();
        
        $this->assertArrayHasKey('created', $errors);
        $this->assertArrayHasKey('modified', $errors);
        $this->assertEquals('A létrehozás ideje nem megfelelő! (éééé-hh-nn óó:pp:mm)', $model1->errors->on('created'));
        $this->assertEquals('A módosítás ideje nem megfelelő! (éééé-hh-nn óó:pp:mm)', $model1->errors->on('modified'));
        
        /* @var $model2 CompleteModel */
        $model2 = CompleteModel::find(1);
        $model2->attachBehavior('timestamp', new Timestamp('created', 'modified'));
        
        $this->assertTrue($model2->is_valid());
        
        $model2->modositas_timestamp = '';
        
        $this->assertFalse($model2->is_valid());
        
        $errors = $model2->errors->to_array();
        
        $this->assertArrayNotHasKey('created', $errors);
        $this->assertArrayHasKey('modified', $errors);
        $this->assertEquals('A módosítás ideje nem megfelelő! (éééé-hh-nn óó:pp:mm)', $model1->errors->on('modified'));
    }
    
    public function testDoesCrudWorkCorrectlyOnAllAttribute()
    {
        $model = $this->createModel();
        
        $model->letrehozas_timestamp = '2015-01-19 11:00:00';
        $model->modositas_timestamp = null;
        
        $this->assertTrue($model->is_valid());
        
        $model->value = 'value';
        
        $this->assertTrue($model->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        
        /* @var $found CompleteModel */
        $found = CompleteModel::find(1);
        $found->attachBehavior('timestamp', new Timestamp('created', 'modified'));
        
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $found->letrehozas_timestamp);
        $this->assertEquals('2015-01-19 11:00:00', $found->letrehozas_timestamp->format('Y-m-d H:i:s'));
        $this->assertNull($found->modositas_timestamp);
        $this->assertFalse($found->attribute_is_dirty('modified'));
        $this->assertFalse($found->is_dirty());
        
        $found->value = 'New Value!';
        
        $this->assertTrue($found->is_dirty());
        $this->assertTrue($found->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $found->modositas_timestamp);
        
        $currentModifiedTimestamp = $found->modositas_timestamp->format('Y-m-d H:i:s');
        
        $found->value = 'New value!';
        
        sleep(1);
        
        $this->assertTrue($found->save());
        $this->assertNotEquals($currentModifiedTimestamp, $found->modositas_timestamp->format('Y-m-d H:i:s'));
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        
        $found->modositas_timestamp = 'xyz';
        
        $this->assertFalse($found->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        
        $errors = $found->errors->to_array();
        
        $this->assertArrayNotHasKey('created', $errors);
        $this->assertArrayHasKey('modified', $errors);
        $this->assertEquals('A módosítás ideje nem megfelelő! (éééé-hh-nn óó:pp:mm)', $found->errors->on('modified'));
        
        $found->modositas_timestamp = '2015-01-01 00:00:00';
        
        $this->assertTrue($found->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals('2015-01-01 00:00:00', $found->modositas_timestamp->format('Y-m-d H:i:s'));
        $this->assertTrue($found->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
    }
    
    public function testDoesCrudWorkCorrectlyOnlyCreatedAttribute()
    {
        $model1 = $this->createCreatedOnlyModel();
        
        $model1->value = 'MyValue';
        
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model1->letrehozas_timestamp);
        
        $exceptionCaught = false;
        try {
            $model1->modositas_timestamp;
        } catch (\ActiveRecord\UndefinedPropertyException $upe) {
            $exceptionCaught = true;
        }
        
        $this->assertTrue($exceptionCaught);
        // Meglévő rekord módosítása.
        /* @var $model2 CompleteModel */
        $model2 = CompleteModel::find(1);
        $model2->attachBehavior('timestamp', new Timestamp('created', null));
        $model2->value = 'SaveMe!';
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertTrue($model2->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
        // Új rekord, meghatározott időbélyeggel.
        $model3 = $this->createCreatedOnlyModel();
        
        $model3->letrehozas_timestamp = '2015-01-20 08:00:00';
        $model3->value = 'Value!';
        
        $this->assertTrue($model3->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model3->letrehozas_timestamp);
        $this->assertEquals('2015-01-20 08:00:00', $model3->letrehozas_timestamp->format('Y-m-d H:i:s'));
        $this->assertNull($model3->modified);
    }
    
    public function testDoesCrudWorkCorrectlyOnlyModifiedAttribute()
    {
        // Új rekord mentése, nem meghatározott időbélyeg.
        $model1 = $this->createModificatoryOnlyModel();
        $model1->value = 'value';
        $exceptionCaught = false;
        try {
            $model1->letrehozas_timestamp = 'x';
        } catch (\ActiveRecord\UndefinedPropertyException $upe) {
            $exceptionCaught = true;
        }
        
        $this->assertNull($model1->created);
        $this->assertNull($model1->modositas_timestamp);
        $this->assertTrue($exceptionCaught);
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertNull($model1->modositas_timestamp);
        
        $model1->value = 'New Value!';
        
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model1->modositas_timestamp);

        $currentModifiedTimestamp = $model1->modositas_timestamp->format('Y-m-d H:i:s');
        
        $model1->value = 1;
        $this->assertFalse($model1->attribute_is_dirty('modified'));
        
        sleep(1);
        
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertNotEquals($currentModifiedTimestamp, $model1->modositas_timestamp->format('Y-m-d H:i:s'));
        // Új rekord, meghatározott időbélyeg.
        $model2 = $this->createModificatoryOnlyModel();
        $model2->value = 'MyValue';
        $model2->modositas_timestamp = '2015-01-20 08:00:00';
        
        $this->assertTrue($model2->save());
        $this->assertEquals(2, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertNull($model2->created);
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $model2->modositas_timestamp);
        $this->assertEquals('2015-01-20 08:00:00', $model2->modositas_timestamp->format('Y-m-d H:i:s'));
        
        $lastModifiedTimestamp = $model2->modositas_timestamp->format('Y-m-d H:i:s');
        // Meglévő rekord frissítése.
        /* @var $model3 CompleteModel */
        $model3 = CompleteModel::find(2);
        $model3->attachBehavior('timestamp', new Timestamp(null, 'modified'));
        $model3->value = 'New Value!';
        
        $this->assertTrue($model3->save());
        $this->assertNotEquals($lastModifiedTimestamp, $model3->modositas_timestamp->format('Y-m-d H:i:s'));
        $this->assertTrue($model3->delete());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertTrue($model2->delete());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertTrue($model1->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
    }
    
    protected function createModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('timestamp', new Timestamp('created', 'modified'));
        return $model;
    }
    
    protected function createCreatedOnlyModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('timestamp', new Timestamp('created', null));
        return $model;
    }
    
    protected function createModificatoryOnlyModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('timestamp', new Timestamp(null, 'modified'));
        return $model;
    }
}