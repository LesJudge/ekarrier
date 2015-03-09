<?php
namespace Tests\Uniweb\Module\Ugyfel\Library;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;

class ClientRepositoryTest extends ActiveRecordTestCase
{
    protected $repo;
    
    public function testFind()
    {
        $this->assertInstanceOf($this->getModelName('Ugyfel.Client'), $this->repo->find(array(
            'conditions' => array(
                'ugyfel_id' => 1
            )
        )));
        
        $client1 = $this->repo->findById(1, array('include' => array('birthdata')));
        
        $this->assertInstanceOf($this->getModelName('Ugyfel.Client'), $client1);
        $this->assertInstanceOf($this->getModelName('Ugyfel.BirthData'), $client1->birthdata);
        
        $clients = $this->repo->find('all');
        
        $this->assertTrue(is_array($clients));
        $this->assertEquals($this->getConnection()->getRowCount('ugyfel'), count($clients));
        
        $firstClient = $this->repo->find('first');
        $this->assertInstanceOf($this->getModelName('Ugyfel.Client'), $firstClient);
        
        $lastClient = $this->repo->find('last');
        $this->assertInstanceOf($this->getModelName('Ugyfel.Client'), $lastClient);
    }
    
    protected function getDataSet()
    {
        $dataset = array(
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/User.xml'),
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/Ugyfel.xml'),
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrSzuletesiAdatok.xml')
        );
        return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataset);
    }
    
    public function setUp()
    {
        $this->repo = new ClientRepository;
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
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_szuletesi_adatok;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');
    }
}