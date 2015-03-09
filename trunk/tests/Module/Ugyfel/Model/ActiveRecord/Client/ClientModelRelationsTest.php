<?php
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;

class ClientModelRelationsTest extends ActiveRecordTestCase
{
    const CLIENT_NS_PREFIX = '\\Uniweb\\Module\\Ugyfel\\Model\\ActiveRecord\\';
    
    public function testRelationsWorkCorrectlyOnAllExistingData()
    {
        /* @var $client \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client */
        $client = Client::find(1);
        
        $addressNsPrefix = self::CLIENT_NS_PREFIX . 'Address\\';
        
        $this->assertInstanceOf(self::CLIENT_NS_PREFIX . 'Client', $client);
        // Munkaerő piaci helyzet kapcsolat.
        $this->assertInstanceOf(self::CLIENT_NS_PREFIX . 'LaborMarket', $client->labormarket);
        // Projekt információ kapcsolat.
        $this->assertInstanceOf(self::CLIENT_NS_PREFIX . 'ProjectInformation', $client->projectinformation);
        // Lakhely kapcsolat.
        $this->assertInstanceOf($addressNsPrefix . 'Residence', $client->addressresidence);
        // Tartózkodási hely kapcsolat.
        $this->assertInstanceOf($addressNsPrefix . 'DwellingPlace', $client->addressdwellingplace);
        // Ideiglenes lakcím kapcsolat.
        $this->assertInstanceOf($addressNsPrefix . 'TemporaryResidence', $client->addresstemporaryresidence);
        // Státusz kapcsolat.
        $this->assertInstanceOf(self::CLIENT_NS_PREFIX . 'Status', $client->status);
        // Születési adatok kapcsolat.
        $this->assertInstanceOf(self::CLIENT_NS_PREFIX . 'BirthData', $client->birthdata);
        
        $status = $client->status;
        $this->assertInstanceOf(self::CLIENT_NS_PREFIX . 'ClientStatus', $status->statuscurrent);
        $this->assertInstanceOf(self::CLIENT_NS_PREFIX . 'ClientStatus', $status->statusnext);
        $this->assertEquals('Státusz 1', $status->statuscurrent->nev);
        $this->assertEquals('Státusz 2', $status->statusnext->nev);
    }
    
    protected function getDataSet()
    {
        $dataSet = array(
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/User.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/BeallitasCimTipus.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UserStatusz.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/Ugyfel.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrSzuletesiAdatok.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrCim.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrMpHelyzet.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrProjektInformacio.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrStatusz.xml')
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
        $pdo->exec('TRUNCATE TABLE ugyfel_statusz;');
        $pdo->exec('TRUNCATE TABLE user;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_szuletesi_adatok;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_munkaeropiaci_helyzet;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_projekt_informacio;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_statusz;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_cim;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');
    }
}