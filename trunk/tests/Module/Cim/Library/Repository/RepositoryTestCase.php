<?php
namespace Tests\Uniweb\Module\Cim\Library\Repository;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;

class RepositoryTestCase extends ActiveRecordTestCase
{
    protected function getDataSet()
    {
        $dataset = array(
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('dataset/cim_orszag.xml')
        );
        return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataset);
    }
}