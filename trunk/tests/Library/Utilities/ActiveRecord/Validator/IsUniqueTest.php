<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Validator;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Uniweb\Library\Utilities\ActiveRecord\Validator\IsUnique;
use Uniweb\Module\Nyelvtudas\Model\ActiveRecord\Level;

class IsUniqueTest extends ActiveRecordTestCase
{
    public function testValidate()
    {
        $newLevel = new Level;
        $validator = new IsUnique($newLevel, 'nev');
        
        $this->assertFalse($validator->validate('Középfokú'));
        $this->assertTrue($validator->validate('Felsőfokú'));
        
        $newLevel->nev = 'Felsőfokú';
        
        $this->assertTrue($newLevel->save());
        
        /* @var $mid \Uniweb\Module\Nyelvtudas\Model\ActiveRecord\Level */
        $mid = Level::find_by_pk(2, array());
        $this->assertTrue($mid->is_valid());
        
        $mid->nev = 'Középfokú';
        
        $this->assertTrue($mid->is_valid());
        
        $mid->nev = 'Alapfokú';
        
        $this->assertFalse($mid->is_valid());
        $this->assertEquals('Ez az érték már használatban van!', $mid->errors->on('nev'));
        
        $mid->nev = 'Felsőfokú';
        
        $this->assertFalse($mid->is_valid());
        $this->assertEquals('Ez az érték már használatban van!', $mid->errors->on('nev'));
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
    
    public function truncateTables()
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