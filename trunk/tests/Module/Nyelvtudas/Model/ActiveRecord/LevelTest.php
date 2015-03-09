<?php
namespace Tests\Uniweb\Module\Nyelvtudas\Model\ActiveRecord;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Uniweb\Module\Nyelvtudas\Model\ActiveRecord\Level;

class LevelTest extends ActiveRecordTestCase
{
    public function testRelations()
    {
        /* @var $level \Uniweb\Module\Nyelvtudas\Model\ActiveRecord\Level */
        $level = Level::find_by_pk(1, array());
        
        $this->assertInstanceOf('\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User', $level->creator);
        $this->assertInstanceOf('\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User', $level->modificatory);
    }
    
    public function testValidate()
    {
        $level = new Level;
        $level->nev = 'Felsőfokú';
        
        $this->assertTrue($level->is_valid());
        
        $level->nev = 'Középfokú';
        
        $this->assertFalse($level->is_valid());
        $this->assertEquals('Ez az érték már használatban van!', $level->errors->on('nev'));
    }
    
    public function setUp()
    {
        \UserLoginOut_Controller::$_id = 1;
        $this->truncateTables();
        parent::setUp();
    }
    
    public function tearDown()
    {
        \UserLoginOut_Controller::$_id = 1;
        $this->truncateTables();
        parent::tearDown();
    }
    
    protected function truncateTables()
    {
        $statement = 'SET FOREIGN_KEY_CHECKS = 0;';
        $statement .= 'TRUNCATE TABLE user;';
        $statement .= 'TRUNCATE TABLE nyelvtudas_szint;';
        $this->getConnection()->getConnection()->exec($statement);
    }
    
    protected function getDataSet()
    {
        $dataset = array(
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('tests/dataset/User.xml'),
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('tests/dataset/NyelvtudasSzint.xml')
        );
        return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataset);
    }
}