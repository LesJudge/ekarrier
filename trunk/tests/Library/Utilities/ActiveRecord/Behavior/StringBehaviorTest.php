<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior\ActiveRecordBehaviorTestCase;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Src\CompleteModel;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\String as StringBehavior;

class StringBehaviorTest extends ActiveRecordBehaviorTestCase
{
    public function testValidate()
    {
        // Kötelező mező, 3 karakter minimum, 128 maximum, nem megegyező hossz.
        $model1 = new CompleteModel;
        $model1->attachBehavior('string', new StringBehavior('value'));

        $this->assertFalse($model1->is_valid());
        
        $this->assertEquals('Kötelező mező!', $model1->errors->on('value'));
        
        $model1->value = 'Val';
        
        $this->assertFalse($model1->is_valid());
        $this->assertEquals('Legalább 4 karakter hosszúnak kell lennie!', $model1->errors->on('value'));
        
        $model1->value = 'Value';
        
        $this->assertTrue($model1->is_valid());
        
        $model1->value = str_repeat('a', 128);
        
        $this->assertFalse($model1->is_valid());
        $this->assertEquals('Legfeljebb 127 karakter hosszú lehet!', $model1->errors->on('value'));
        // Kötelező mező, 3 karakter minimum, 128 karakter maximum, megegyezhető hosszúság.
        $model2 = new CompleteModel;
        $model2->attachBehavior('string', new StringBehavior('value', true, 3, 128, true));
        
        $this->assertFalse($model2->is_valid());
        
        $this->assertEquals('Kötelező mező!', $model2->errors->on('value'));
        
        $model2->value = 'Va';
        
        $this->assertFalse($model2->is_valid());
        $this->assertEquals('Legalább 3 karakter hosszúnak kell lennie!', $model2->errors->on('value'));
        
        $model2->value = 'Value';
        
        $this->assertTrue($model2->is_valid());
        
        $model2->value = str_repeat('a', 128);
        
        $this->assertTrue($model2->is_valid());
        
        $model2->value = str_repeat('b', 200);
        
        $this->assertFalse($model2->is_valid());
        $this->assertEquals('Legfeljebb 128 karakter hosszú lehet!', $model2->errors->on('value'));
        // Kötelező mező, nem meghatározott minimális és maximális hossz, megegyezhető hossz.
        $model3 = new CompleteModel;
        $model3->attachBehavior('string', new StringBehavior('value', true, null, null, true));
        
        $this->assertFalse($model3->is_valid());
        $this->assertEquals('Kötelező mező!', $model3->errors->on('value'));
        
        $model3->value = str_repeat('a', 300);
        
        $this->assertTrue($model3->is_valid());
        // Kötelező mező, nem meghatározott minimális hossz, 128 maximális hossz, megegyezhető hossz.
        $model4 = new CompleteModel;
        $model4->attachBehavior('string', new StringBehavior('value', true, null, 128, true));
        
        $this->assertFalse($model4->is_valid());
        $this->assertEquals('Kötelező mező!', $model4->errors->on('value'));
        
        $model4->value = 'Value';
        
        $this->assertTrue($model4->is_valid());
        
        $model4->value = str_repeat('a', 129);
        
        $this->assertFalse($model4->is_valid());
        $this->assertEquals('Legfeljebb 128 karakter hosszú lehet!', $model4->errors->on('value'));
        // Nem kötelező mező, 3 karakter minimum, 128 maximum, megegyezhető hossz.
        $model5 = new CompleteModel;
        $model5->attachBehavior('string', new StringBehavior('value', false, 3, 128, true));
        
        $this->assertTrue($model5->is_valid());
        
        $model5->value = 'Va';
        
        $this->assertFalse($model5->is_valid());
        $this->assertEquals('Legalább 3 karakter hosszúnak kell lennie!', $model5->errors->on('value'));
        
        $model5->value = 'Value';
        
        $this->assertTrue($model5->is_valid());
        
        $model5->value = str_repeat('a', 129);
        
        $this->assertFalse($model5->is_valid());
        $this->assertEquals('Legfeljebb 128 karakter hosszú lehet!', $model5->errors->on('value'));
        // Nem kötelező mező, nem meghatározott minimális és maximális hossz, megegyezhető hossz.
        $model6 = new CompleteModel;
        $model6->attachBehavior('string', new StringBehavior('value', false, null, null, true));
        
        $this->assertTrue($model6->is_valid());
        // Nem kötelező mező, 3 karakter minimum, nincs maximális hossz, nem megegyező hossz.
        $model7 = new CompleteModel;
        $model7->attachBehavior('string', new StringBehavior('value', false, 3, null, false));
        
        $this->assertTrue($model7->is_valid());
        
        $model7->value = 'Val';
        
        $this->assertFalse($model7->is_valid());
        $this->assertEquals('Legalább 4 karakter hosszúnak kell lennie!', $model7->errors->on('value'));
        
        $model7->value = str_repeat('z', 1000);
        
        $this->assertTrue($model7->is_valid());
    }
}