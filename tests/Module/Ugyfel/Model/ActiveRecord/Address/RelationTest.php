<?php
namespace Tests\Uniweb\Module\Ugyfel\Model\ActiveRecord\Address;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Tests\Uniweb\Helper\UserRelationHelper;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;
use Uniweb\Module\Cim\Model\ActiveRecord\Country;
use Uniweb\Module\Cim\Model\ActiveRecord\County;
use Uniweb\Module\Cim\Model\ActiveRecord\City;
use Uniweb\Module\Cim\Model\ActiveRecord\ZipCode;
use PHPUnit_Extensions_Database_DataSet_XmlDataSet;
use PHPUnit_Extensions_Database_DataSet_CompositeDataSet;

class RelationTest extends ActiveRecordTestCase
{
    /**
     * @var \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client[]
     */
    public $clients = array();
    
    public function testDoesClientsHasCorrectAddressRelations()
    {
        $baseArNs = '\\Uniweb\\Module\\%s\\Model\\ActiveRecord\\';
        $addressArNs = sprintf($baseArNs, 'Cim');
        $clientArNs = sprintf($baseArNs, 'Ugyfel');
        $settingsArNs = sprintf($baseArNs, 'Beallitas');
        
        $firstClient = $this->clients[0];
        $this->assertInstanceOf($clientArNs . 'Address\\Residence', $firstClient->addressresidence);
        $this->assertInstanceOf($clientArNs . 'Address\\DwellingPlace', $firstClient->addressdwellingplace);
        $this->assertInstanceOf($clientArNs . 'Address\\TemporaryResidence', $firstClient->addresstemporaryresidence);
        
        $firstClientResidence = $firstClient->addressresidence;
        $this->assertInstanceOf($settingsArNs . 'AddressType', $firstClientResidence->type);
        $this->assertInstanceOf($addressArNs . 'County', $firstClientResidence->county);
        $this->assertInstanceOf($addressArNs . 'Country', $firstClientResidence->country);
        $this->assertInstanceOf($addressArNs . 'City', $firstClientResidence->city);
        $this->assertInstanceOf($addressArNs . 'ZipCode', $firstClientResidence->zipcode);
        
        $this->assertEquals(4, $firstClientResidence->ugyfel_attr_cim_id);
        $this->assertEquals('Lakcím', $firstClientResidence->type->nev);
        $this->assertEquals('Teszt utca', $firstClientResidence->utca);
        $this->assertEquals(10, $firstClientResidence->hazszam);
        
        $firstClientResidenceCounty = $firstClientResidence->county;
        $this->assertEquals('Szabolcs-Szatmár-Bereg', $firstClientResidenceCounty->cim_megye_nev);
        $this->assertEquals(1, $firstClientResidenceCounty->cim_megye_id);
        $this->assertEquals(1, $firstClientResidenceCounty->cim_megye_aktiv);
        $this->assertEquals(0, $firstClientResidenceCounty->cim_megye_torolt);
        
        $firstClientResidenceCountry = $firstClientResidence->country;
        $this->assertEquals('Magyarország', $firstClientResidenceCountry->nev);
        $this->assertEquals('HU', $firstClientResidenceCountry->kod);
        $this->assertEquals(1, $firstClientResidenceCountry->cim_orszag_aktiv);
        $this->assertEquals(0, $firstClientResidenceCountry->cim_orszag_torolt);
        
        $firstClientResidenceCity = $firstClientResidence->city;
        $this->assertEquals('Nyíregyháza', $firstClientResidenceCity->cim_varos_nev);
        $this->assertEquals(1, $firstClientResidenceCity->cim_varos_aktiv);
        $this->assertEquals(0, $firstClientResidenceCity->cim_varos_torolt);
        
        $firstClientResidenceZipCode = $firstClientResidence->zipcode;
        $this->assertEquals(4400, $firstClientResidenceZipCode->iranyitoszam);
        $this->assertEquals(1, $firstClientResidenceZipCode->cim_iranyitoszam_aktiv);
        $this->assertEquals(0, $firstClientResidenceZipCode->cim_iranyitoszam_torolt);
        
        $firstClientDwellingPlace = $firstClient->addressdwellingplace;
        $this->assertInstanceOf($settingsArNs . 'AddressType', $firstClientDwellingPlace->type);
        $this->assertInstanceOf($addressArNs . 'County', $firstClientDwellingPlace->county);
        $this->assertInstanceOf($addressArNs . 'Country', $firstClientDwellingPlace->country);
        $this->assertInstanceOf($addressArNs . 'City', $firstClientDwellingPlace->city);
        $this->assertInstanceOf($addressArNs . 'ZipCode', $firstClientDwellingPlace->zipcode);
        
        $this->assertEquals('Tartózkodási hely', $firstClientDwellingPlace->type->nev);
        $this->assertEquals('Teszt utca (tartózkodási hely)', $firstClientDwellingPlace->utca);
        $this->assertEquals(10, $firstClientDwellingPlace->hazszam);
        
        $firstClientDwellingPlaceCounty = $firstClientDwellingPlace->county;
        $this->assertEquals('Szabolcs-Szatmár-Bereg', $firstClientDwellingPlaceCounty->cim_megye_nev);
        $this->assertEquals(1, $firstClientDwellingPlaceCounty->cim_megye_id);
        
        $firstClientDwellingPlaceCountry = $firstClientDwellingPlace->country;
        $this->assertEquals('Magyarország', $firstClientDwellingPlaceCountry->nev);
        $this->assertEquals('HU', $firstClientDwellingPlaceCountry->kod);
        
        $this->assertEquals('Nyíregyháza', $firstClientDwellingPlace->city->cim_varos_nev);
        
        $this->assertEquals(4400, $firstClientDwellingPlace->zipcode->iranyitoszam);
        
        $firstClientTemporaryResidence = $firstClient->addresstemporaryresidence;
        $this->assertInstanceOf($settingsArNs . 'AddressType', $firstClientTemporaryResidence->type);
        $this->assertNull($firstClientTemporaryResidence->county);
        $this->assertNull($firstClientTemporaryResidence->country);
        $this->assertNull($firstClientTemporaryResidence->city);
        $this->assertNull($firstClientTemporaryResidence->zipcode);
        
        $this->assertEquals('Ideiglenes lakcím', $firstClientTemporaryResidence->type->nev);
        
        $secondClient = $this->clients[1];
        $this->assertInstanceOf($clientArNs . 'Address\\Residence', $secondClient->addressresidence);
        $this->assertInstanceOf($clientArNs . 'Address\\DwellingPlace', $secondClient->addressdwellingplace);
        $this->assertNull($secondClient->addresstemporaryresidence);
        
        $secondClientResidence = $secondClient->addressresidence;
        $this->assertInstanceOf($settingsArNs . 'AddressType', $secondClientResidence->type);
        $this->assertInstanceOf($addressArNs . 'County', $secondClientResidence->county);
        $this->assertInstanceOf($addressArNs . 'Country', $secondClientResidence->country);
        $this->assertInstanceOf($addressArNs . 'City', $secondClientResidence->city);
        $this->assertInstanceOf($addressArNs . 'ZipCode', $secondClientResidence->zipcode);
        
        $this->assertEquals('Lakcím', $secondClientResidence->type->nev);
        $this->assertEquals('Második ügyfél lakcím utca', $secondClientResidence->utca);
        $this->assertEquals(11, $secondClientResidence->hazszam);
        
        $secondClientResidenceCountry = $secondClientResidence->country;
        $this->assertEquals('Magyarország', $secondClientResidenceCountry->nev);
        $this->assertEquals('HU', $secondClientResidenceCountry->kod);
        
        $secondClientResidenceCounty = $secondClientResidence->county;
        $this->assertEquals('Hajdú-Bihar', $secondClientResidenceCounty->cim_megye_nev);
        $this->assertEquals(2, $secondClientResidenceCounty->cim_megye_id);
        
        $this->assertEquals('Debrecen', $secondClientResidence->city->cim_varos_nev);
        
        $this->assertEquals(4030, $secondClientResidence->zipcode->iranyitoszam);
        
        $secondClientDwellingPlace = $secondClient->addressdwellingplace;
        $this->assertInstanceOf($settingsArNs . 'AddressType', $secondClientDwellingPlace->type);
        $this->assertInstanceOf($addressArNs . 'County', $secondClientDwellingPlace->county);
        $this->assertInstanceOf($addressArNs . 'Country', $secondClientDwellingPlace->country);
        $this->assertNull($secondClientDwellingPlace->city);
        $this->assertNull($secondClientDwellingPlace->zipcode);
        
        $this->assertEquals('Tartózkodási hely', $secondClientDwellingPlace->type->nev);
        $this->assertEquals('Második ügyfél tartózkodási hely utca', $secondClientDwellingPlace->utca);
        $this->assertEquals(12, $secondClientDwellingPlace->hazszam);
        
        $this->assertEquals('Ausztria', $secondClientDwellingPlace->country->nev);
        $this->assertEquals('AU', $secondClientDwellingPlace->country->kod);
        
        $this->assertEquals('Szabolcs-Szatmár-Bereg', $secondClientDwellingPlace->county->cim_megye_nev);
    }
    
    public function testDoesCityHasCorrectCountyRelations()
    {
        $this->assertEquals('Szabolcs-Szatmár-Bereg', $this->clients[0]->addressresidence->city->county->cim_megye_nev);
        $this->assertEquals(
            'Szabolcs-Szatmár-Bereg', $this->clients[0]->addressdwellingplace->city->county->cim_megye_nev
        );
        $this->assertEquals(null, $this->clients[0]->addresstemporaryresidence->city->county->cim_megye_nev);
        $this->assertEquals('Hajdú-Bihar', $this->clients[1]->addressresidence->city->county->cim_megye_nev);
        $this->assertEquals(null, $this->clients[1]->addressdwellingplace->city->county->cim_megye_nev);
    }
    
    public function testDoesCityHasCorrectCountryRelations()
    {
        $this->assertEquals('Magyarország', $this->clients[0]->addressresidence->city->country->nev);
        $this->assertEquals('Magyarország', $this->clients[0]->addressdwellingplace->city->country->nev);
        $this->assertEquals(null, $this->clients[0]->addresstemporaryresidence->city->country->nev);
        $this->assertEquals('Magyarország', $this->clients[1]->addressresidence->city->country->nev);
        $this->assertEquals(null, $this->clients[1]->addressdwellingplace->city->country->nev);
    }
    
    public function testDoesZipCodeHasCorrectCityRelations()
    {
        $this->assertEquals('Nyíregyháza', $this->clients[0]->addressresidence->zipcode->city->cim_varos_nev);
        $this->assertEquals('Nyíregyháza', $this->clients[0]->addressdwellingplace->zipcode->city->cim_varos_nev);
        $this->assertEquals(null, $this->clients[0]->addresstemporaryresidence->zipcode->city->cim_varos_nev);
        $this->assertEquals('Debrecen', $this->clients[1]->addressresidence->zipcode->city->cim_varos_nev);
        $this->assertEquals(null, $this->clients[1]->addressdwellingplace->zipcode->city->cim_varos_nev);
    }

    public function testDoesCountriesHasCorrectUserRelations()
    {
        $userDataTable = $this->getDataSet()->getTable('user');
        $countries = array();
        $countries[] = Country::find(1);
        $countries[] = Country::find(2);
        $countries[] = Country::find(3);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $countries[0]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $countries[0]->modificatory);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $countries[1]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $countries[1]->modificatory);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $countries[2]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $countries[2]->modificatory);
    }
    
    public function testDoesCountiesHasCorrenctUserRelations()
    {
        $userDataTable = $this->getDataSet()->getTable('user');
        $counties = array();
        $counties[] = County::find(1);
        $counties[] = County::find(2);
        $counties[] = County::find(3);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $counties[0]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $counties[0]->modificatory);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $counties[1]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $counties[1]->modificatory);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $counties[2]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $counties[2]->modificatory);
    }
    
    public function testDoesCitiesHasCorrectUserRelations()
    {
        $userDataTable = $this->getDataSet()->getTable('user');
        $cities = array();
        $cities[] = City::find(1);
        $cities[] = City::find(2);
        $cities[] = City::find(3);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $cities[0]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $cities[0]->modificatory);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $cities[1]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $cities[1]->modificatory);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $cities[2]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $cities[2]->modificatory);
    }
    
    public function testDoesZipCodesHasCorrectUserRelations()
    {
        $userDataTable = $this->getDataSet()->getTable('user');
        $zipCodes = array();
        $zipCodes[] = ZipCode::find(1);
        $zipCodes[] = ZipCode::find(2);
        $zipCodes[] = ZipCode::find(3);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $zipCodes[0]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $zipCodes[0]->modificatory);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $zipCodes[1]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $zipCodes[1]->modificatory);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(0), $zipCodes[2]->creator);
        UserRelationHelper::testUserRelation($this, $userDataTable->getRow(1), $zipCodes[2]->modificatory);
    }
    
    protected function getDataSet()
    {
        $dataSet = array(
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/User.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/BeallitasCimTipus.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimOrszag.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimMegye.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimVaros.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimIranyitoszam.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrCim.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/Ugyfel.xml'),
        );
        return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataSet);
    }
    
    public function setUp()
    {
        $this->truncateTables();
        parent::setUp();
        $this->clients[0] = Client::find(1);
        $this->clients[1] = Client::find(2);
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
        $pdo->exec('TRUNCATE TABLE ugyfel_cim_tipus;');
        $pdo->exec('TRUNCATE TABLE cim_orszag;');
        $pdo->exec('TRUNCATE TABLE cim_megye;');
        $pdo->exec('TRUNCATE TABLE cim_varos;');
        $pdo->exec('TRUNCATE TABLE cim_iranyitoszam;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_cim;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');
    }
}