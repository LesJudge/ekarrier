<?php
namespace Tests\Uniweb\Module\Ugyfel\Model\ActiveRecord\Birthdata;
use Tests\Uniweb\Module\Ugyfel\Model\ActiveRecord\Birthdata\AbstractTestCase;
use stdClass;
use Rimo;

class BehaviorTest extends AbstractTestCase
{
    public function testDoesDependenciesSolvedOnFoundRecords()
    {
        /* @var $birthData \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData */
        foreach ($this->birthDatas as $birthData) {
            $this->assertBehaviorContainer($birthData);
        }
    }
    
    public function testDoesDependenciesSolvedOnFindByPk()
    {
        $this->assertBehaviorContainer(\Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData::find_by_pk(1, array()));
    }
    
    public function testDoesTimestampBehaviorWorksFineOnFoundInstance()
    {
        /* @var $birthData \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData */
        $birthData = \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData::find_by_pk(1, array());
        
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $birthData->letrehozas_timestamp);
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $birthData->get_letrehozas_timestamp());
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $birthData->in('timestamp')->get_letrehozas_timestamp());
        
        $letrehozas_timestamp = array();
        $letrehozas_timestamp[] = $birthData->letrehozas_timestamp;
        $letrehozas_timestamp[] = $birthData->get_letrehozas_timestamp();
        $letrehozas_timestamp[] = $birthData->in('timestamp')->get_letrehozas_timestamp();
        
        $dataset = $this->getDataSet()->getTable('ugyfel_attr_szuletesi_adatok');
        $client1 = $dataset->getRow(0);
        
        foreach ($letrehozas_timestamp as $timestamp) {
            $this->assertEquals($client1['letrehozas_timestamp'], $timestamp->format('Y-m-d H:i:s'));
        }
        
        $this->assertNull($birthData->modositas_timestamp);
        $this->assertNull($birthData->get_modositas_timestamp());
        $this->assertNull($birthData->in('timestamp')->get_modositas_timestamp());
        
        $birthData->letrehozas_timestamp = new stdClass;
        
        $this->assertEquals(false, $birthData->in('timestamp')->get_letrehozas_timestamp());
        
        $birthData->set_letrehozas_timestamp(false);
        $this->assertFalse($birthData->letrehozas_timestamp);
        
        $birthData->in('timestamp')->set_letrehozas_timestamp(null);
        $this->assertNull($birthData->get_letrehozas_timestamp());
    }
    
    public function testDoesModificationsBehaviorWorksFineOnFoundInstance()
    {
        /* @var $birthData \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData */
        $birthData = \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData::find_by_pk(1, array());
        
        $dataset = $this->getDataSet()->getTable('ugyfel_attr_szuletesi_adatok');
        $client1 = $dataset->getRow(0);
        
        $this->assertEquals($client1['modositas_szama'], $birthData->modositas_szama);
        $this->assertEquals($client1['modositas_szama'], $birthData->get_modositas_szama());
        $this->assertEquals($client1['modositas_szama'], $birthData->in('modifications')->get_modositas_szama());
        
        $birthData->modositas_szama = 10;
        $this->assertEquals(10, $birthData->in('modifications')->get_modositas_szama());
        
        $birthData->set_modositas_szama(array());
        $this->assertEquals(array(), $birthData->get_modositas_szama());
        
        $birthData->in('modifications')->set_modositas_szama(false);
        $this->assertEquals(false, $birthData->modositas_szama);
    }
    
    public function testDoesAuthorBehaviorWorksFineOnFoundInstance()
    {
        /* @var $birthData \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData */
        $birthData = \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData::find_by_pk(1, array());
        
        $dataset = $this->getDataSet()->getTable('ugyfel_attr_szuletesi_adatok');
        $client1 = $dataset->getRow(0);
        
        $this->assertEquals($client1['letrehozo_id'], $birthData->letrehozo_id);
        $this->assertEquals($client1['letrehozo_id'], $birthData->get_letrehozo_id());
        $this->assertEquals($client1['letrehozo_id'], $birthData->in('author')->get_letrehozo_id());
        
        $this->assertEquals($client1['modosito_id'], $birthData->modosito_id);
        $this->assertEquals($client1['modosito_id'], $birthData->get_modosito_id());
        $this->assertEquals($client1['modosito_id'], $birthData->in('author')->get_modosito_id());
        
        $birthData->letrehozo_id = 5;
        $this->assertEquals(5, $birthData->in('author')->get_letrehozo_id());
        
        $birthData->set_letrehozo_id(array());
        $this->assertEquals(array(), $birthData->get_letrehozo_id());
        
        $stdClass = new stdClass;
        $birthData->in('author')->set_letrehozo_id($stdClass);
        $this->assertEquals($stdClass, $birthData->letrehozo_id);
        
        $birthData->modosito_id = 1.75;
        $this->assertEquals(1.75, $birthData->in('author')->get_modosito_id());
        
        $birthData->set_modosito_id(false);
        $this->assertFalse($birthData->get_modosito_id());
        
        $birthData->in('author')->set_modosito_id('string');
        $this->assertEquals('string', $birthData->modosito_id);
    }
    
    public function testDoesDependenciesSolvedWhenIInstantiateFromPimple()
    {
        /* @var $birthData \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData */
        $birthData = Rimo::$pimple['BirthDataModel'];
        
        $this->assertBehaviorContainer($birthData);
    }
    
    public function testDoesTimestampBehaviorWorksFineOnNewInstace()
    {
        /* @var $birthData \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData */
        $birthData = Rimo::$pimple['BirthDataModel'];
        
        $this->assertNull($birthData->letrehozas_timestamp);
        $this->assertNull($birthData->get_letrehozas_timestamp());
        $this->assertNull($birthData->in('timestamp')->get_letrehozas_timestamp());
        
        $this->assertNull($birthData->modositas_timestamp);
        $this->assertNull($birthData->get_modositas_timestamp());
        $this->assertNull($birthData->in('timestamp')->get_letrehozas_timestamp());
        
        $birthData->letrehozas_timestamp = '2015-01-13 12:00:00';
        $this->assertInstanceOf('\\ActiveRecord\\DateTime', $birthData->letrehozas_timestamp);
        $this->assertEquals('2015-01-13 12:00:00', $birthData->letrehozas_timestamp->format('Y-m-d H:i:s'));
        
        $birthData->set_letrehozas_timestamp(new stdClass);
        $this->assertFalse($birthData->get_letrehozas_timestamp());
        
        $birthData->in('timestamp')->set_letrehozas_timestamp(array());
        $this->assertFalse($birthData->in('timestamp')->get_letrehozas_timestamp());
    }
    
    public function testDoesModificationsBehaviorWorksFineOnNewInstance()
    {
        /* @var $birthData \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData */
        $birthData = Rimo::$pimple['BirthDataModel'];
        
        $this->assertEquals(0, $birthData->modositas_szama);
        $this->assertEquals(0, $birthData->get_modositas_szama());
        $this->assertEquals(0, $birthData->in('modifications')->get_modositas_szama());
        
        $birthData->modositas_szama = 'z';
        $this->assertEquals('z', $birthData->modositas_szama);
        
        $birthData->set_modositas_szama(false);
        $this->assertFalse($birthData->get_modositas_szama());
        
        $birthData->in('modifications')->set_modositas_szama(array());
        $this->assertEquals(array(), $birthData->in('modifications')->get_modositas_szama());
    }
    
    public function testDoesAuthorBehaviorWorksFineOnNewInstance()
    {
        /* @var $birthData \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData */
        $birthData = Rimo::$pimple['BirthDataModel'];
        
        $this->assertNull($birthData->letrehozo_id);
        $this->assertNull($birthData->get_letrehozo_id());
        $this->assertNull($birthData->in('author')->get_letrehozo_id());
        
        $this->assertNull($birthData->modosito_id);
        $this->assertNull($birthData->get_modosito_id());
        $this->assertNull($birthData->in('author')->get_modosito_id());        
        
        $birthData->letrehozo_id = 1.5;
        $this->assertEquals(1.5, $birthData->letrehozo_id);
        
        $birthData->set_letrehozo_id(-2);
        $this->assertEquals(-2, $birthData->get_letrehozo_id());
        
        $birthData->in('author')->set_letrehozo_id(3.7);
        $this->assertEquals(3.7, $birthData->in('author')->get_letrehozo_id());

        $birthData->modosito_id = 'string';
        $this->assertEquals('string', $birthData->modosito_id);
        
        $birthData->set_modosito_id(100);
        $this->assertEquals(100, $birthData->get_modosito_id());
        
        $stdClass = new stdClass;
        $birthData->in('author')->set_modosito_id($stdClass);
        $this->assertEquals($stdClass, $birthData->in('author')->get_modosito_id());
    }
    
    public function testDoesTimestampBehaviorValidatorWorksCorrectly()
    {
        /* @var $birthData \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData */
        $birthData = Rimo::$pimple['BirthDataModel'];
        
        $birthData->getBehaviorContainer()->detachBehavior('author');
        $birthData->getBehaviorContainer()->detachBehavior('modifications');
        
        $this->assertCount(1, $birthData->getBehaviorContainer());
        
        $birthData->letrehozas_timestamp = '2015-01-15 15:00:00';
        $birthData->modositas_timestamp = null;
        $birthData->is_valid();
        
        $this->assertEquals(1, $birthData->errors->size());
        
        $errors = $birthData->errors->to_array();
        
        $this->assertArrayHasKey('ugyfel_id', $errors);
        $this->assertEquals('Az ügyfél azonosító nem megfelelő!', $birthData->errors->on('ugyfel_id'));
        
        $birthData->letrehozas_timestamp = 'string';
        $birthData->is_valid();
        
        $this->assertCount(2, $birthData->errors);
        
        $errors = $birthData->errors->to_array();
        
        $this->assertArrayHasKey('ugyfel_id', $errors);
        $this->assertArrayHasKey('letrehozas_timestamp', $errors);
        $this->assertEquals('Az ügyfél azonosító nem megfelelő!', $birthData->errors->on('ugyfel_id'));
        $this->assertEquals(
            'A létrehozás ideje nem megfelelő! (éééé-hh-nn óó:pp:mm)', $birthData->errors->on('letrehozas_timestamp')
        );
        $this->assertArrayNotHasKey('modositas_timestamp', $errors);
        
        $birthData->ugyfel_id = 1;
        $birthData->letrehozas_timestamp = null;
        $birthData->modositas_timestamp = new stdClass;
        $birthData->is_valid();
        
        $errors = $birthData->errors->to_array();
        
        $this->assertCount(1, $errors);
        $this->assertArrayHasKey('modositas_timestamp', $errors);
        $this->assertArrayNotHasKey('ugyfel_id', $errors);
        $this->assertArrayNotHasKey('letrehozas_timestamp', $errors);
        $this->assertEquals(
            'A módosítás ideje nem megfelelő! (éééé-hh-nn óó:pp:mm)', $birthData->errors->on('modositas_timestamp')
        );
    }
    /**
     * @expectedException \ActiveRecord\ActiveRecordException
     * @expectedExceptionMessage undefined method: in
     */
    public function testDoesItThrowExceptionWhenDependeciesAreUnsolved()
    {
        $birthData = new \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData;
        $birthData->in('author')->get_letrehozo_id();
    }
    
    protected function assertBehaviorContainer($model)
    {
        $this->assertCount(3, $model->getBehaviorContainer());
        $this->assertTrue($model->getBehaviorContainer()->hasBehavior('author'));
        $this->assertTrue($model->getBehaviorContainer()->hasBehavior('modifications'));
        $this->assertTrue($model->getBehaviorContainer()->hasBehavior('timestamp'));
        
        foreach ($model->getBehaviorContainer() as $behavior) {
            /* @var $behavior \Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface */
            $this->assertInstanceOf($this->getModelName('Ugyfel.BirthData'), $behavior->getOwner());
        }
        
        $this->assertEquals('letrehozo_id', $model->in('author')->getCreatorAttribute());
        $this->assertEquals('letrehozo_id', $model->getCreatorAttribute());
        $this->assertEquals('modosito_id', $model->in('author')->getModificatoryAttribute());
        $this->assertEquals('modosito_id', $model->getModificatoryAttribute());
        $this->assertEquals('letrehozas_timestamp', $model->in('timestamp')->getCreatedAttribute());
        $this->assertEquals('letrehozas_timestamp', $model->getCreatedAttribute());
        $this->assertEquals('modositas_timestamp', $model->in('timestamp')->getModifiedAttribute());
        $this->assertEquals('modositas_timestamp', $model->getModifiedAttribute());
        $this->assertEquals('modositas_szama', $model->in('modifications')->getNomAttribute());
        $this->assertEquals('modositas_szama', $model->getNomAttribute());
    }
}
