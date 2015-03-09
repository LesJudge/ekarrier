<?php
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;

class StatusTest extends ActiveRecordTestCase
{
    /**
     * @var \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client[]
     */
    protected $clients;
    
    public function testDoesClientsHasCorrectCurrentRelationInstances()
    {
        $this->assertInstanceOf($this->getModelName('Ugyfel.ClientStatus'), $this->clients[0]->status->statuscurrent);
        $this->assertNull($this->clients[1]->status->statuscurrent);
        $this->assertInstanceOf($this->getModelName('Ugyfel.ClientStatus'), $this->clients[2]->status->statuscurrent);
    }
    
    public function testDoesClientsHasCorrectNextRelationInstances()
    {
        $this->assertInstanceOf($this->getModelName('Ugyfel.ClientStatus'), $this->clients[0]->status->statusnext);
        $this->assertNull($this->clients[1]->status->statusnext);
        $this->assertNull($this->clients[2]->status->statusnext);
    }
    
    public function testDoesStatusHasCorrectCreatorInstances()
    {
        $this->assertInstanceOf($this->getModelName('User.User'), $this->clients[0]->status->creator);
        $this->assertInstanceOf($this->getModelName('User.User'), $this->clients[1]->status->creator);
        $this->assertNull($this->clients[2]->status->creator);
    }
    
    public function testDoesStatusHasCorrectModificatoryInstances()
    {
        $this->assertInstanceOf($this->getModelName('User.User'), $this->clients[0]->status->modificatory);
        $this->assertInstanceOf($this->getModelName('User.User'), $this->clients[1]->status->modificatory);
        $this->assertNull($this->clients[2]->status->modificatory);
    }
    
    public function testDoesItRetrieveCorrectStatusCurrentRelation()
    {
        $statusesTable = $this->getDataSet()->getTable('ugyfel_statusz');
        
        $firstStatus = $statusesTable->getRow(0);
        $firstCurrent = $this->clients[0]->status->statuscurrent;
        
        $secondCurrent = $this->clients[1]->status->statuscurrent;
        
        $thirdStatus = $statusesTable->getRow(1);
        $thirdCurrent = $this->clients[2]->status->statuscurrent;
        
        $this->assertEquals($firstStatus['ugyfel_statusz_id'], $firstCurrent->ugyfel_statusz_id);
        $this->assertEquals($firstStatus['nev'], $firstCurrent->nev);
        $this->assertEquals($firstStatus['letrehozo_id'], $firstCurrent->letrehozo_id);
        $this->assertEquals($firstStatus['modosito_id'], $firstCurrent->modosito_id);
        $this->assertEquals($firstStatus['modositas_szama'], $firstCurrent->modositas_szama);
        
        $this->assertNull($secondCurrent->ugyfel_statusz_id);
        $this->assertNull($secondCurrent->nev);
        $this->assertNull($secondCurrent->letrehozo_id);
        $this->assertNull($secondCurrent->modosito_id);
        $this->assertNull($secondCurrent->modositas_szama);
        
        $this->assertEquals($thirdStatus['ugyfel_statusz_id'], $thirdCurrent->ugyfel_statusz_id);
        $this->assertEquals($thirdStatus['nev'], $thirdCurrent->nev);
        $this->assertEquals($thirdStatus['letrehozo_id'], $thirdCurrent->letrehozo_id);
        $this->assertEquals($thirdStatus['modosito_id'], $thirdCurrent->modosito_id);
        $this->assertEquals($thirdStatus['modositas_szama'], $thirdCurrent->modositas_szama);
    }
    
    public function testDoesItRetrieveCorrectStatusNextRelation()
    {
        $statusesTable = $this->getDataSet()->getTable('ugyfel_statusz');
        
        $firstStatus = $statusesTable->getRow(1);
        $firstNext = $this->clients[0]->status->statusnext;
        $secondNext = $this->clients[1]->status->statusnext;
        $thirdNext = $this->clients[2]->status->statusnext;
        
        $this->assertEquals($firstStatus['ugyfel_statusz_id'], $firstNext->ugyfel_statusz_id);
        $this->assertEquals($firstStatus['nev'], $firstNext->nev);
        $this->assertEquals($firstStatus['letrehozo_id'], $firstNext->letrehozo_id);
        $this->assertEquals($firstStatus['modosito_id'], $firstNext->modosito_id);
        $this->assertEquals($firstStatus['modositas_szama'], $firstNext->modositas_szama);
        
        $this->assertNull($secondNext->ugyfel_statusz_id);
        $this->assertNull($secondNext->nev);
        $this->assertNull($secondNext->letrehozo_id);
        $this->assertNull($secondNext->modosito_id);
        $this->assertNull($secondNext->modositas_szama);
        
        $this->assertNull($thirdNext->ugyfel_statusz_id);
        $this->assertNull($thirdNext->nev);
        $this->assertNull($thirdNext->letrehozo_id);
        $this->assertNull($thirdNext->modosito_id);
        $this->assertNull($thirdNext->modositas_szama);
    }
    
    public function testDoesItRetrieveCorrectClientStatusRecord()
    {
        $clientStatusTable = $this->getDataSet()->getTable('ugyfel_attr_statusz');
        $clientStatuses[] = array();
        $clientStatuses[0] = $clientStatusTable->getRow(0);
        $clientStatuses[1] = $clientStatusTable->getRow(1);
        $clientStatuses[2] = $clientStatusTable->getRow(2);
        
        foreach ($clientStatuses as $k => $v) {
            $this->assertEquals($v['aktualis_statusz'], $this->clients[$k]->status->aktualis_statusz);
            $this->assertEquals($v['kovetkezo_statusz'], $this->clients[$k]->status->kovetkezo_statusz);
            $this->assertEquals($v['idotartam'], $this->clients[$k]->status->idotartam);
            $this->assertEquals($v['letrehozo_id'], $this->clients[$k]->status->letrehozo_id);
            $this->assertEquals($v['modosito_id'], $this->clients[$k]->status->modosito_id);
        }
    }
    
    protected function getDataSet()
    {
        $dataSet = array(
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/User.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/Ugyfel.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UserStatusz.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrStatusz.xml')
        );
        return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataSet);
    }
    
    public function setUp()
    {
        $this->truncateTables();
        parent::setUp();
        $this->clients = array();
        $this->clients[0] = Client::find(1);
        $this->clients[1] = Client::find(2);
        $this->clients[2] = Client::find(3);
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
        $pdo->exec('TRUNCATE TABLE ugyfel_statusz;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_statusz;');
    }
}