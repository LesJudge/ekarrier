<?php
namespace Tests\Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource\Education as DeleteEducationsByResource;

class Education extends ActiveRecordTestCase
{
    public function testDeletesEducationsByResource()
    {
        $client = Client::find_by_pk(1, array());
        
        $deleteByResource = new DeleteEducationsByResource;
        $deleteByResource->deleteByResource($client);
        
        $this->assertEquals(0, $this->getConnection()->getRowCount(
            'ugyfel_attr_vegzettseg', 'ugyfel_id = 1 AND ugyfel_attr_vegzettseg_torolt = 0'
        ));
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_vegzettseg', 'ugyfel_id = 1 AND ugyfel_attr_vegzettseg_torolt = 1'
        ));
    }
    
    public function setUp()
    {
        $statement = 'SET FOREIGN_KEY_CHECKS=0;';
        $statement .= 'TRUNCATE TABLE user;';
        $statement .= 'TRUNCATE TABLE ugyfel;';
        $statement .= 'TRUNCATE TABLE ugyfel_attr_vegzettseg;';
        $this->getConnection()->getConnection()->exec($statement);
        parent::setUp();
    }
    
    public function tearDown()
    {
        $statement = 'SET FOREIGN_KEY_CHECKS=0;';
        $statement .= 'TRUNCATE TABLE user;';
        $statement .= 'TRUNCATE TABLE ugyfel;';
        $statement .= 'TRUNCATE TABLE ugyfel_attr_vegzettseg;';
        $this->getConnection()->getConnection()->exec($statement);
        parent::tearDown();
    }
    
    protected function getDataSet()
    {
        $dataset = array(
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('tests/dataset/User.xml'),
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('tests/dataset/Ugyfel.xml'),
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('tests/dataset/UgyfelAttrVegzettseg.xml')
        );
        return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataset);
    }
}