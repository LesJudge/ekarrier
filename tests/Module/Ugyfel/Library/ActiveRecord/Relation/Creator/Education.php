<?php
namespace Tests\Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Uniweb\Module\Ugyfel\Library\ActiveRecord\Relation\Creator\Education as EducationCreator;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\DeleteByResource\Education as EducationDeleteByResource;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Education as EducationModel;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;
use UserLoginOut_Controller;

class Education extends ActiveRecordTestCase
{
    public function testMarksAsUndeletedOnSaveAfterDelete()
    {
        $client = Client::find_by_pk(1, array());
        
        $delete = new EducationDeleteByResource;
        $delete->deleteByResource($client);
        
        $this->assertEquals(0, $this->getConnection()->getRowCount(
            'ugyfel_attr_vegzettseg', 'ugyfel_id = 1 AND ugyfel_attr_vegzettseg_torolt = 0'
        ));
        
        $creator = new EducationCreator;
        $creator->setModel(new EducationModel);
        $created = $creator->create(array(
            'ugyfel_attr_vegzettseg_id' => 1,
            'megnevezes' => 'Megnevezés módosítva'
        ));
        
        $created->save();
        
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_vegzettseg', 'ugyfel_id = 1 AND ugyfel_attr_vegzettseg_torolt = 0'
        ));
        $this->assertEquals(1, $this->getConnection()->getRowCount(
            'ugyfel_attr_vegzettseg', 'ugyfel_id = 1 AND ugyfel_attr_vegzettseg_torolt = 1'
        ));
        $this->assertEquals(0, EducationModel::find_by_pk(1, array())->ugyfel_attr_vegzettseg_torolt);
        $this->assertEquals(1, EducationModel::find_by_pk(2, array())->ugyfel_attr_vegzettseg_torolt);
    }
    
    public function setUp()
    {
        \UserLoginOut_Controller::$_id = 1;
        $statement = 'SET FOREIGN_KEY_CHECKS = 0;';
        $statement .= 'TRUNCATE TABLE user;';
        $statement .= 'TRUNCATE TABLE ugyfel;';
        $statement .= 'TRUNCATE TABLE ugyfel_attr_vegzettseg;';
        $this->getConnection()->getConnection()->exec($statement);
        parent::setUp();
    }
    
    public function tearDown()
    {
        $statement = 'SET FOREIGN_KEY_CHECKS = 0;';
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