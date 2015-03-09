<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Behavior\ActiveRecordBehaviorTestCase;
use Tests\Uniweb\Library\Utilities\ActiveRecord\Src\CompleteModel;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\NumberOfModifications;

class NumberOfModificationsTest extends ActiveRecordBehaviorTestCase
{
    public function testDoesGetterSetterWorksCorrectly()
    {
        $model = $this->createModel();
        
        $this->assertEquals(0, $model->modositas_szama);
        $this->assertEquals(0, $model->get_modositas_szama());
        $this->assertEquals(0, $model->in('nom')->get_modositas_szama());
        
        $model->modositas_szama = 1;
        
        $this->assertEquals(1, $model->modositas_szama);
        $this->assertEquals(1, $model->get_modositas_szama());
        $this->assertEquals(1, $model->in('nom')->get_modositas_szama());
        
        $model->set_modositas_szama(array());
        
        $this->assertEquals(array(), $model->modositas_szama);
        $this->assertEquals(array(), $model->get_modositas_szama());
        $this->assertEquals(array(), $model->in('nom')->get_modositas_szama());
        
        $model->in('nom')->set_modositas_szama(1.75);
        
        $this->assertEquals(1.75, $model->modositas_szama);
        $this->assertEquals(1.75, $model->get_modositas_szama());
        $this->assertEquals(1.75, $model->in('nom')->get_modositas_szama());
    }
    /**
     * 
     * @param type $value
     * @param type $expected
     * @dataProvider dataProvider
     */
    public function testDoesItValidateCorrectly($value, $expected)
    {
        $model = $this->createModel();
        $model->set_modositas_szama($value);
        
        $this->assertEquals($expected, $model->is_valid());
    }
    
    public function testDoesCrudWorkCorrectly()
    {
        $model1 = $this->createModel();
        $model1->value = 'Value';
        
        $this->assertEquals(0, $model1->modositas_szama);
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(0, $model1->modositas_szama);
        
        $model1->value = 'NewValue';
        
        $this->assertTrue($model1->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(1, $model1->modositas_szama);
        
        /* @var $model2 CompleteModel */
        $model2 = CompleteModel::find(1);
        $model2->attachBehavior('nom', new NumberOfModifications('nom'));
        
        $this->assertEquals(1, $model2->modositas_szama);
        
        $model2->value = 'Try to update!';
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(2, $model2->modositas_szama);
        
        $model2->modositas_szama = 100;
        
        $this->assertTrue($model2->save());
        $this->assertEquals(1, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(100, $model2->in('nom')->get_modositas_szama());
        
        $model2->value = 'new value';
        
        $this->assertTrue($model2->save());
        $this->assertEquals(101, $model2->modositas_szama);
        
        $model3 = $this->createModel();
        $model3->value = 'some string';
        $model3->modositas_szama = 50;
        
        $this->assertTrue($model3->save());
        $this->assertEquals(2, $this->getConnection()->getRowCount('ar_behavior_complete'));
        
        $model3->value = 'here is some text';
        
        $this->assertTrue($model3->save());
        $this->assertEquals(2, $this->getConnection()->getRowCount('ar_behavior_complete'));
        $this->assertEquals(51, $model3->modositas_szama);
        
        $this->assertTrue($model1->delete());
        $this->assertTrue($model2->delete());
        $this->assertTrue($model3->delete());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
        
        $model4 = $this->createModel();
        $model4->value = 'value';
        $model4->modositas_szama = 4.5;
        
        $this->assertFalse($model4->save());
        $this->assertEquals(0, $this->getConnection()->getRowCount('ar_behavior_complete'));
    }
    
    public function dataProvider()
    {
        return array(
            array(0, true),
            array(1.75, false),
            array(new \stdClass, false),
            array(-1, false),
            array(1, true),
            array(array(), false),
            array(true, false),
            array(false, false),
            array(null, true)
        );
    }
    /**
     * 
     * @return \CompleteModel
     */
    public function createModel()
    {
        $model = new CompleteModel;
        $model->attachBehavior('nom', new NumberOfModifications('nom'));
        return $model;
    }
}