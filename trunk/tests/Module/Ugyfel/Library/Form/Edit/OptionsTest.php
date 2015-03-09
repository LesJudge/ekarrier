<?php
namespace Tests\Uniweb\Module\Ugyfel\Library\Form\Edit;
use Uniweb\Library\Cache\Adapter\GregwarCacheAdapter;
use Gregwar\Cache\Cache;
use Uniweb\Module\Ugyfel\Library\Form\Edit\Options;

class OptionsTest extends \ActiveRecordTestCase
{
    public function testOk()
    {
        $gregwarCache = new Cache('cache/data');
        $gregwarCache->setPrefixSize(0);
        
        $cache = new GregwarCacheAdapter($gregwarCache);
        
        $options = new Options($cache);
        
        $data = $options->assign();
        
        $this->assertArrayHasKey('beallitasAddressType', $data);
        $this->assertCount($this->getDataSet()->getTable('ugyfel_cim_tipus')->getRowCount(), $data['beallitasAddressType']);
        
    }
    
    protected function getDataSet()
    {
        $dataSet = array(
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/BeallitasCimTipus.xml'),
            new \PHPUnit_Extensions_Database_DataSet_XmlDataSet('./tests/Client/dataset/BeallitasHovaErkezett.xml')
        );
        return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataSet);
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
        $pdo->exec('TRUNCATE TABLE karrierpont;');
    }
}
