<?php
use Uniweb\Module\Ugyfel\Model\ActiveRecord\ProjectInformation;

class ProjectInformationModelRelationsTest extends ActiveRecordTestCase
{
    public function testDoesRelationsWorkCorrectlyOnAllExistingData()
    {
        /* @var $projectInformation \Uniweb\Module\Ugyfel\Model\ActiveRecord\ProjectInformation */
        $projectInformation = ProjectInformation::find(1);
        
        $this->assertInstanceOf(
            '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\CameTo', $projectInformation->cameto
        );
        $this->assertInstanceOf('\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User', $projectInformation->creator);
        $this->assertInstanceOf('\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User', $projectInformation->modificatory);
        
        $cameToAttributes = $projectInformation->cameto->attributes();
        $this->assertArrayHasKey('karrierpont_id', $cameToAttributes);
        $this->assertArrayHasKey('nev', $cameToAttributes);
        $this->assertArrayNotHasKey('letrehozo_id', $cameToAttributes);
        $this->assertArrayNotHasKey('karrierpont_aktiv', $cameToAttributes);
        
        $creatorData = array(
            'user_vnev' => 'Uniweb',
            'user_knev' => 'Admin1',
            'user_email' => 'uniwebadmin1@uniweb.hu',
            'user_fnev' => 'uniweb_admin_1'
        );
        UserRelationHelper::testUserRelation($this, $creatorData, $projectInformation->creator);
        
        $modificatoryData = array(
            'user_vnev' => 'Uniweb',
            'user_knev' => 'Admin1',
            'user_email' => 'uniwebadmin1@uniweb.hu',
            'user_fnev' => 'uniweb_admin_1'
        );
        UserRelationHelper::testUserRelation($this, $modificatoryData, $projectInformation->modificatory);
    }
    
    public function testDoesRelationsWorkCorrectlyOnNotAllExistingData()
    {
        /* @var $projectInformation \Uniweb\Module\Ugyfel\Model\ActiveRecord\ProjectInformation */
        $projectInformation = ProjectInformation::find(2);
        $this->assertEquals(null, $projectInformation->cameto);
        $this->assertEquals(null, $projectInformation->creator);
        $this->assertEquals(null, $projectInformation->modificatory);
        
        $projectInformation = ProjectInformation::find(3);
        $this->assertInstanceOf(
            '\\Uniweb\\Module\\Beallitas\\Model\\ActiveRecord\\CameTo', $projectInformation->cameto
        );
        $this->assertEquals(null, $projectInformation->creator);
        $firstUserData = array(
            'user_vnev' => 'Uniweb',
            'user_knev' => 'Admin1',
            'user_email' => 'uniwebadmin1@uniweb.hu',
            'user_fnev' => 'uniweb_admin_1'
        );
        UserRelationHelper::testUserRelation($this, $firstUserData, $projectInformation->modificatory);
        
        $projectInformation = ProjectInformation::find(4);
        $this->assertEquals(null, $projectInformation->cameto);
        UserRelationHelper::testUserRelation($this, $firstUserData, $projectInformation->creator);
        UserRelationHelper::testUserRelation($this, $firstUserData, $projectInformation->modificatory);
    }
    /**
     * @expectedException \ActiveRecord\RecordNotFound
     */
    public function testDoesItThrowExceptionOnNotExistingRecord()
    {
        ProjectInformation::find(100);
    }
    
    protected function getDataSet()
    {
        $dataSet = array(
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/User.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/Ugyfel.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrProjektInformacio.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/BeallitasHovaErkezett.xml')
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
        $pdo->exec('TRUNCATE TABLE karrierpont;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_projekt_informacio;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');        
    }
}