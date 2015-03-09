<?php
use Uniweb\Module\Ugyfel\Model\ActiveRecord\LaborMarket;

class LaborMarketTest extends ActiveRecordTestCase
{
    public function testDoesRelationsWorkCorrectlyOnAllExistingData()
    {
        /* @var $laborMarket \Uniweb\Module\Ugyfel\Model\ActiveRecord\LaborMarket */
        $laborMarket = LaborMarket::find(1);
        
        $this->assertInstanceOf('\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User', $laborMarket->creator);
        $this->assertInstanceOf('\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User', $laborMarket->modificatory);

        $creatorData = array(
            'user_vnev' => 'Uniweb',
            'user_knev' => 'Admin1',
            'user_email' => 'uniwebadmin1@uniweb.hu',
            'user_fnev' => 'uniweb_admin_1'
        );
        UserRelationHelper::testUserRelation($this, $creatorData, $laborMarket->creator);
        
        $modificatoryData = array(
            'user_vnev' => 'Uniweb',
            'user_knev' => 'Admin2',
            'user_email' => 'uniwebadmin2@uniweb.hu',
            'user_fnev' => 'uniweb_admin_2'
        );
        UserRelationHelper::testUserRelation($this, $modificatoryData, $laborMarket->modificatory);
    }
    
    public function testDoesRelationsWorkCorrectlyOnNotAllExistingData()
    {
        /* @var $laborMarket \Uniweb\Module\Ugyfel\Model\ActiveRecord\LaborMarket */
        $laborMarket = LaborMarket::find(2);
        
        $this->assertInstanceOf('\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User', $laborMarket->creator);
        $creatorData = array(
            'user_vnev' => 'Uniweb',
            'user_knev' => 'Admin1',
            'user_email' => 'uniwebadmin1@uniweb.hu',
            'user_fnev' => 'uniweb_admin_1'            
        );
        UserRelationHelper::testUserRelation($this, $creatorData, $laborMarket->creator);
        
        $this->assertEquals(null, $laborMarket->modificatory);
    }
    /**
     * @expectedException \ActiveRecord\RecordNotFound
     */
    public function testDoesItThrowExceptionOnNotExistingRecord()
    {
        LaborMarket::find(100);
    }
    
    protected function getDataSet()
    {
        $dataSet = array(
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/User.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/Ugyfel.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrMpHelyzet.xml')
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
        $pdo->exec('TRUNCATE TABLE user;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_munkaeropiaci_helyzet;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');        
    }
}