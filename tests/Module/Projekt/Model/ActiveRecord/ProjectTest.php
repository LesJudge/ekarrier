<?php
namespace Tests\Uniweb\Module\Projekt\Model\ActiveRecord;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Uniweb\Module\Projekt\Model\ActiveRecord\Project;
/**
 * @todo Befejezni, alap modul model teszt esetet csinálni belőle!
 */
class ProjectTest extends ActiveRecordTestCase
{
    public function testValidation()
    {
        $project = new Project;
        // Név mező.
        $this->assertFalse($project->is_valid());
        $this->assertEquals('Kötelező mező!', $project->errors->on('nev'));
        
        $project->nev = 'Teszt projekt 1';
        
        $this->assertFalse($project->is_valid());
        $this->assertEquals('Ez az érték már használatban van!', $project->errors->on('nev'));
        
        $project->nev = 'A';
        
        $this->assertFalse($project->is_valid());
        $this->assertEquals('Legalább 3 karakter hosszúnak kell lennie!', $project->errors->on('nev'));
        
        $project->nev = str_repeat('a', 300);
        
        $this->assertFalse($project->is_valid());
        $this->assertEquals('Legfeljebb 128 karakter hosszú lehet!', $project->errors->on('nev'));
        
        $project->nev = 'Teszt projekt 3';
        
        $this->assertTrue($project->is_valid());
        // Létrehozás ideje
        
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
        $statement .= 'TRUNCATE TABLE ugyfel;';
        $statement .= 'TRUNCATE TABLE projekt;';
        $statement .= 'TRUNCATE TABLE ugyfel_attr_projekt';
        $this->getConnection()->getConnection()->exec($statement);
    }
    
    protected function getDataSet()
    {
        $dataset = array(
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('tests/dataset/User.xml'),
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('tests/dataset/Ugyfel.xml'),
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('tests/dataset/Projekt.xml'),
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('tests/dataset/UgyfelAttrProjekt.xml'),
        );
        return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataset);
    }
}