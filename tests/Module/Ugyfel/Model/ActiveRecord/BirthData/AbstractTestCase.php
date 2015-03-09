<?php
namespace Tests\Uniweb\Module\Ugyfel\Model\ActiveRecord\Birthdata;
use Tests\Uniweb\TestCase\ActiveRecordTestCase;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData;
use PHPUnit_Extensions_Database_DataSet_XmlDataSet;
use PHPUnit_Extensions_Database_DataSet_CompositeDataSet;
use Rimo;

abstract class AbstractTestCase extends ActiveRecordTestCase
{
    /**
     * @var \Uniweb\Module\Ugyfel\Model\ActiveRecord\BirthData[]
     */
    protected $birthDatas;
    
    protected function getDataSet()
    {
        $dataSet = array(
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/User.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimOrszag.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/CimVaros.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/Ugyfel.xml'),
            new PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/UgyfelAttrSzuletesiAdatok.xml')
        );
        return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataSet);
    }
    
    public function setUp()
    {
        $this->truncateTables();
        parent::setUp();
        Rimo::$pimple = new \Pimple\Container;
        Rimo::$pimple['BehaviorContainer'] = Rimo::$pimple->factory(function($c) {
            return new \Uniweb\Library\Utilities\Behavior\BehaviorContainer;
        });
        Rimo::$pimple->register(new \Uniweb\Module\Ugyfel\Library\DependencyInjection\BirthData);
        
        $this->birthDatas = array();
        $this->birthDatas[0] = BirthData::find(1);
        $this->birthDatas[1] = BirthData::find(2);
        $this->birthDatas[2] = BirthData::find(3);
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
        $pdo->exec('TRUNCATE TABLE cim_orszag;');
        $pdo->exec('TRUNCATE TABLE cim_varos;');
        $pdo->exec('TRUNCATE TABLE ugyfel;');
        $pdo->exec('TRUNCATE TABLE ugyfel_attr_szuletesi_adatok;');
    }
}