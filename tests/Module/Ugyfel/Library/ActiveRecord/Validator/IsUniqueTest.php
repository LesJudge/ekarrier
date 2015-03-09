<?php
use Uniweb\Module\Beallitas\Model\ActiveRecord\AddressType;
use Uniweb\Library\Utilities\ActiveRecord\Validator\IsUnique;

class IsUniqueTest extends ActiveRecordTestCase
{
    public function testDoesItValidateCorrectly()
    {
        $instance1 = new IsUnique(new AddressType, 'nev');
        $this->assertEquals(true, $instance1->validate('newValue'));
        $this->assertEquals(false, $instance1->validate('Lakcím'));
        $this->assertEquals(true, $instance1->validate('Lakciim'));
        
        $instance2 = new IsUnique(AddressType::find(1), 'nev');
        $this->assertEquals(true, $instance2->validate('Lakcím'));
        $this->assertEquals(true, $instance2->validate('Lakcim'));
    }
    
    protected function getDataSet()
    {
        $dataSet = array(
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/BeallitasCimTipus.xml')
        );
        return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataSet);
    }
    
    public function setUp()
    {
        $this->truncateTables();
        parent::setUp();
    }
    
    public function tearDown()
    {
        $this->truncateTables();
        parent::tearDown();
    }
    
    protected function truncateTables()
    {
        $pdo = $this->getConnection()->getConnection();
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');
        $pdo->exec('TRUNCATE TABLE ugyfel_cim_tipus;');    
    }
}