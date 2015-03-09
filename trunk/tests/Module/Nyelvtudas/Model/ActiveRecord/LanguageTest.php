<?php
namespace Tests\Uniweb\Module\Nyelvtudas\Model\ActiveRecord;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;

class LanguageTest extends ActiveRecordTestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
    
    protected function getDataSet()
    {
        $dataset = array(
            
        );
        return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataset);
    }
}