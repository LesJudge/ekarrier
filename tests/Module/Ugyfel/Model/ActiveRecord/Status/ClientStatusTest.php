<?php
use Uniweb\Module\Ugyfel\Model\ActiveRecord\ClientStatus;

class ClientStatusTest extends ActiveRecordTestCase
{
    /**
     * @var \Uniweb\Module\Ugyfel\Model\ActiveRecord\ClientStatus[]
     */
    protected $clientStatuses;
    
    protected $userModelNs = '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User';
    
    public function testDoesItRetrieveCorrectCreatorInstance()
    {
        $this->assertInstanceOf($this->userModelNs, $this->clientStatuses[0]->creator);
        $this->assertInstanceOf($this->userModelNs, $this->clientStatuses[1]->creator);
        $this->assertInstanceOf($this->userModelNs, $this->clientStatuses[2]->creator);
        $this->assertNull($this->clientStatuses[3]->creator);
    }
    
    public function testDoesItRetrieveCorrectModificatoryInstance()
    {
        $this->assertInstanceOf($this->userModelNs, $this->clientStatuses[0]->modificatory);
        $this->assertInstanceOf($this->userModelNs, $this->clientStatuses[1]->modificatory);
        $this->assertInstanceOf($this->userModelNs, $this->clientStatuses[2]->modificatory);
        $this->assertNull($this->clientStatuses[3]->modificatory);        
    }
    
    public function testDoesItRetrieveCorrectCreatorRecord()
    {
        $usersTable = $this->getDataSet()->getTable('user');
        UserRelationHelper::testUserRelation($this, $usersTable->getRow(0), $this->clientStatuses[0]->creator);
        UserRelationHelper::testUserRelation($this, $usersTable->getRow(1), $this->clientStatuses[1]->creator);
        UserRelationHelper::testUserRelation($this, $usersTable->getRow(0), $this->clientStatuses[2]->creator);
    }
    
    public function testDoesItRetrieveCorrectModificatoryRecord()
    {
        $usersTable = $this->getDataSet()->getTable('user');
        UserRelationHelper::testUserRelation($this, $usersTable->getRow(0), $this->clientStatuses[0]->modificatory);
        UserRelationHelper::testUserRelation($this, $usersTable->getRow(1), $this->clientStatuses[1]->modificatory);
        UserRelationHelper::testUserRelation($this, $usersTable->getRow(1), $this->clientStatuses[2]->modificatory);        
    }

    public function testDoesItInvalidWhenNewAndNameExists()
    {
        $clientStatus = new ClientStatus;
        $clientStatus->nev = 'Státusz 1';
        $clientStatus->letrehozo_id = 1;
        $clientStatus->modosito_id = 1;
        $clientStatus->letrehozas_timestamp = '2015-01-07 14:00:00';
        $clientStatus->modositas_timestamp = '0000-00-00 00:00:00';
        
        $this->assertFalse($clientStatus->is_valid());
    }

    public function testDoesItValidWhenNewAndNameDoesNotExists()
    {
        $clientStatus = new ClientStatus;
        $clientStatus->nev = 'A new status';
        $clientStatus->letrehozo_id = 1;
        $clientStatus->modosito_id = 1;
        $clientStatus->letrehozas_timestamp = '2015-01-07 14:00:00';
        $clientStatus->modositas_timestamp = '0000-00-00 00:00:00';
        
        $this->assertTrue($clientStatus->is_valid());
    }

    public function testDoesItValidAfterSaveAndIsUnique()
    {
        $clientStatus = new ClientStatus;
        $clientStatus->nev = 'A new status';
        $clientStatus->letrehozo_id = 1;
        $clientStatus->modosito_id = 1;
        $clientStatus->letrehozas_timestamp = '2015-01-07 14:00:00';
        $clientStatus->modositas_timestamp = '0000-00-00 00:00:00';
        $clientStatus->save();
        
        $this->assertTrue($clientStatus->is_valid());
    }
    
    public function testCanIAddNewUniqueNameForAnExistingStatus()
    {
        /* @var $clientStatus \Uniweb\Module\Ugyfel\Model\ActiveRecord\ClientStatus */
        $clientStatus = ClientStatus::find(1);
        $clientStatus->nev = 'A new unique name';
        $this->assertTrue($clientStatus->save());
    }
    
    public function testDoesItFailWhenIAddNotUniqueNameForExistingStatus()
    {
        /* @var $clientStatus \Uniweb\Module\Ugyfel\Model\ActiveRecord\ClientStatus */
        $clientStatus = ClientStatus::find(1);
        $clientStatus->nev = 'Státusz 2';
        $this->assertFalse($clientStatus->save());
    }
    
    protected function getDataSet()
    {
        $dataSet = array(
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/User.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/Ugyfel.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UserStatusz.xml')
        );
        return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataSet);
    }
    
    public function setUp()
    {
        $this->truncateTables();
        parent::setUp();
        $this->clientStatuses = array();
        $this->clientStatuses[0] = ClientStatus::find(1);
        $this->clientStatuses[1] = ClientStatus::find(2);
        $this->clientStatuses[2] = ClientStatus::find(3);
        $this->clientStatuses[3] = ClientStatus::find(4);
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
        $pdo->exec('TRUNCATE TABLE ugyfel;');
        $pdo->exec('TRUNCATE TABLE ugyfel_statusz;');
    }
}