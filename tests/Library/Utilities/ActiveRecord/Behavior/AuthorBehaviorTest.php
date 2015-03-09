<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior\ActiveRecordBehaviorTestCase;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Src\CompleteModel;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\Author;
use UserLoginOut_Controller;

class AuthorBehaviorTest extends ActiveRecordBehaviorTestCase
{
    public function testDoesGetterSetterWorksCorrectlyWhenAllAttributesDefined()
    {
        $model1 = $this->createModel();
        
        $this->assertNull($model1->letrehozo_id);
        $this->assertNull($model1->modosito_id);
        $this->assertNull($model1->get_letrehozo_id());
        $this->assertNull($model1->get_modosito_id());
        $this->assertNull($model1->in('author')->get_letrehozo_id());
        $this->assertNull($model1->in('author')->get_modosito_id());
        
        $model1->letrehozo_id = 1;
        $this->assertEquals(1, $model1->letrehozo_id);
        $this->assertEquals(1, $model1->get_letrehozo_id());
        $this->assertEquals(1, $model1->in('author')->get_letrehozo_id());
        $this->assertNull($model1->modosito_id);
        $this->assertNull($model1->get_modosito_id());
        $this->assertNull($model1->in('author')->get_modosito_id());
        
        $model1->set_letrehozo_id(1.5);
        $this->assertEquals(1.5, $model1->letrehozo_id);
        $this->assertEquals(1.5, $model1->get_letrehozo_id());
        $this->assertEquals(1.5, $model1->in('author')->get_letrehozo_id());
        $this->assertNull($model1->modosito_id);
        $this->assertNull($model1->get_modosito_id());
        $this->assertNull($model1->in('author')->get_modosito_id());
        
        $model1->in('author')->set_letrehozo_id(array());
        $this->assertEquals(array(), $model1->letrehozo_id);
        $this->assertEquals(array(), $model1->get_letrehozo_id());
        $this->assertEquals(array(), $model1->in('author')->get_letrehozo_id());
        $this->assertNull($model1->modosito_id);
        $this->assertNull($model1->get_modosito_id());
        $this->assertNull($model1->in('author')->get_modosito_id());
        
        $model1->modosito_id = array(array());
        $this->assertEquals(array(), $model1->modosito_id);
        $this->assertEquals(array(), $model1->get_modosito_id());
        $this->assertEquals(array(), $model1->in('author')->get_modosito_id());
        $this->assertEquals(array(), $model1->letrehozo_id);
        $this->assertEquals(array(), $model1->get_letrehozo_id());
        $this->assertEquals(array(), $model1->in('author')->get_letrehozo_id());
        
        $stdClass = new \stdClass;
        $model1->set_modosito_id($stdClass);
        $this->assertEquals($stdClass, $model1->modosito_id);
        $this->assertEquals($stdClass, $model1->get_modosito_id());
        $this->assertEquals($stdClass, $model1->in('author')->get_modosito_id());
        $this->assertEquals(array(), $model1->letrehozo_id);
        $this->assertEquals(array(), $model1->get_letrehozo_id());
        $this->assertEquals(array(), $model1->in('author')->get_letrehozo_id());
        
        $model1->in('author')->set_modosito_id(false);
        $this->assertEquals(false, $model1->modosito_id);
        $this->assertEquals(false, $model1->get_modosito_id());
        $this->assertEquals(false, $model1->in('author')->get_modosito_id());
        $this->assertEquals(array(), $model1->letrehozo_id);
        $this->assertEquals(array(), $model1->get_letrehozo_id());
        $this->assertEquals(array(), $model1->in('author')->get_letrehozo_id());
    }
    
    public function testDoesItValidateCorrectly()
    {
        $model1 = $this->createModel();
        
        $model1->letrehozo_id = 1;
        $model1->modosito_id = 1;
        
        $this->assertTrue($model1->is_valid());
        
        $model1->letrehozo_id = 1.5;
        
        $this->assertFalse($model1->is_valid());
        
        $errors = $model1->errors->to_array();
        
        $this->assertArrayHasKey('creator', $errors);
        $this->assertArrayNotHasKey('modificatory', $errors);
        $this->assertEquals('A létrehozó felhasználó azonosítója nem megfelelő!', $model1->errors->on('creator'));
        
        $model1->modosito_id = false;
        
        $this->assertFalse($model1->is_valid());
        
        $errors = $model1->errors->to_array();
        
        $this->assertArrayHasKey('creator', $errors);
        $this->assertArrayHasKey('modificatory', $errors);
        $this->assertEquals('A létrehozó felhasználó azonosítója nem megfelelő!', $model1->errors->on('creator'));
        $this->assertEquals('A módosító felhasználó azonosítója nem megfelelő!', $model1->errors->on('modificatory'));
        
        $model1->set_letrehozo_id(10);
        
        $this->assertFalse($model1->is_valid());
        
        $errors = $model1->errors->to_array();
        
        $this->assertArrayHasKey('modificatory', $errors);
        $this->assertArrayNotHasKey('creator', $errors);
        $this->assertEquals('A módosító felhasználó azonosítója nem megfelelő!', $model1->errors->on('modificatory'));
        
        $model1->set_modosito_id(10);
        $model1->in('author')->set_letrehozo_id(new \stdClass);
        
        $this->assertFalse($model1->is_valid());
        
        $errors = $model1->errors->to_array();
        
        $this->assertArrayHasKey('creator', $errors);
        $this->assertArrayNotHasKey('modificatory', $errors);
        $this->assertEquals('A létrehozó felhasználó azonosítója nem megfelelő!', $model1->errors->on('creator'));
        
        $model1->letrehozo_id = 10;
        $model1->in('author')->set_modosito_id(11);
        
        $this->assertTrue($model1->is_valid());
        
        $errors = $model1->errors->to_array();
        
        $this->assertEmpty($errors);
    }
    
    public function testDoesItThrowExceptionWhenITryToAccessUndefinedAttribute()
    {
        $model1 = $this->createCreatorOnlyModel();
        $model2 = $this->createModificatoryOnlyModel();

        $this->assertNull($model1->letrehozo_id);
        $this->assertNull($model1->get_letrehozo_id());
        $this->assertNull($model1->in('author')->get_letrehozo_id());
        
        $catchException = function($callback) {
            $caughtException = false;
            try {
                call_user_func($callback);
            } catch (\ActiveRecord\UndefinedPropertyException $upe) {
                $caughtException = true;
            }
            return $caughtException;
        };
        
        $this->assertTrue($catchException(function() use ($model1) { $model1->modosito_id; }));
        $this->assertTrue($catchException(function() use ($model1) { $model1->get_modosito_id(); }));
        $this->assertTrue($catchException(function() use ($model1) { $model1->in('author')->get_modosito_id(); }));
        $this->assertTrue($catchException(function() use ($model2) { $model2->letrehozo_id; }));
        $this->assertTrue($catchException(function() use ($model2) { $model2->get_letrehozo_id(); }));
        $this->assertTrue($catchException(function() use ($model2) { $model2->in('author')->get_letrehozo_id(); }));
    }
    
    public function testDoesCrudWorkCorrectlyOnAllAttribute()
    {
        UserLoginOut_Controller::$_id = 1;
        
        $model1 = $this->createModel();
        $model1->value = 'Value!';
        // Új rekord mentése.
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $model1->letrehozo_id);
        $this->assertEquals(1, $model1->modosito_id);
        $this->assertEquals(1, $model1->get_letrehozo_id());
        $this->assertEquals(1, $model1->get_modosito_id());
        $this->assertEquals(1, $model1->in('author')->get_letrehozo_id());
        $this->assertEquals(1, $model1->in('author')->get_modosito_id());
        $this->assertFalse($model1->is_new_record());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEmpty($model1->errors->to_array());
        
        $model1->value = 'New Value!';
        // Meglévő rekord módosítása.
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $model1->letrehozo_id);
        $this->assertEquals(1, $model1->modosito_id);
        $this->assertEquals(1, $model1->get_letrehozo_id());
        $this->assertEquals(1, $model1->get_modosito_id());
        $this->assertEquals(1, $model1->in('author')->get_letrehozo_id());
        $this->assertEquals(1, $model1->in('author')->get_modosito_id());
        $this->assertEquals('New Value!', $model1->value);
        $this->assertFalse($model1->is_new_record());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEmpty($model1->errors->to_array());
        
        $model1->letrehozo_id = new \stdClass;
        $model1->modosito_id = array(array());
        $model1->value = 'New again.';
        // Mentés hibás adatokkal.
        $this->assertFalse($model1->save());
        
        $errors = $model1->errors->to_array();
        
        $this->assertArrayHasKey('creator', $errors);
        $this->assertArrayHasKey('modificatory', $errors);
        $this->assertEquals('A létrehozó felhasználó azonosítója nem megfelelő!', $model1->errors->on('creator'));
        $this->assertEquals('A módosító felhasználó azonosítója nem megfelelő!', $model1->errors->on('modificatory'));
        
        /* @var $model2 CompleteModel */
        $model2 = CompleteModel::find(1);
        $model2->attachBehavior('author', new Author('creator', 'modificatory'));
        $model2->value = 'Hey!';
        $model2->modosito_id = 2;
        
        $this->assertTrue($model2->attribute_is_dirty('modificatory'));
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $model2->letrehozo_id);
        $this->assertEquals(2, $model2->modosito_id);
        $this->assertEquals('Hey!', $model2->value);
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertTrue($model2->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
    }
    
    public function testDoesCrudWorkCorrectlyOnlyCreatorAttribute()
    {
        UserLoginOut_Controller::$_id = 1; // "Szerencsére" emiatt körülményes lenne mock-olni. :)
        
        $model1 = $this->createCreatorOnlyModel();
        $model1->value = 'Value';
        
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals('Value', $model1->value);
        $this->assertEquals(1, $model1->letrehozo_id);
        $this->assertNull($model1->modificatory);
        
        /* @var $model2 CompleteModel */
        $model2 = CompleteModel::find(1);
        $model2->attachBehavior('alias', new Author('creator', null));
        $model2->value = 'New';
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(1, $model2->letrehozo_id);
        $this->assertEquals(0, $model2->modificatory);
        
        $model2->letrehozo_id = 20;
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(20, $model2->letrehozo_id);
        $this->assertEquals(0, $model2->modificatory);
        $this->assertTrue($model2->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
    }
    
    public function testDoesCrudWorkCorrectlyOnlyModificatoryAttribute()
    {
        UserLoginOut_Controller::$_id = 1;
        
        $model1 = $this->createModificatoryOnlyModel();
        $model1->value = 'Value';
        
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertNull($model1->creator);
        $this->assertEquals(1, $model1->modificatory);
        
        $model1->modosito_id = 100;
        
        $this->assertTrue($model1->save());
        $this->assertEquals(100, $model1->modosito_id);
        
        /* @var $model2 CompleteModel */
        $model2 = CompleteModel::find(1);
        $model2->attachBehavior('author', new Author(null, 'modificatory'));
        $model2->value = 'MyValue';
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(1, $model2->modosito_id);
        
        $model2->modosito_id = 50;
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(50, $model2->modosito_id);
        $this->assertTrue($model2->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
        
        $model3 = $this->createModificatoryOnlyModel();
        $model3->value = 'Value!';
        $model3->modosito_id = 1.5;
        
        $this->assertFalse($model3->save());
        
        $errors = $model3->errors->to_array();
        
        $this->assertArrayHasKey('modificatory', $errors);
        $this->assertEquals('A módosító felhasználó azonosítója nem megfelelő!', $model3->errors->on('modificatory'));
        
        $model3->modosito_id = 10;
        
        $this->assertTrue($model3->save());
    }
    
    protected function createModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('author', new Author('creator', 'modificatory'));
        return $model;
    }

    protected function createCreatorOnlyModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('author', new Author('creator', null));
        return $model;
    }
    
    protected function createModificatoryOnlyModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('author', new Author(null, 'modificatory'));
        return $model;
    }
}