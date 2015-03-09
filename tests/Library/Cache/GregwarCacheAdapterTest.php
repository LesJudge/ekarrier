<?php
namespace Tests\Uniweb\Library\Cache;
use PHPUnit_Framework_TestCase;
use Gregwar\Cache\Cache;
use Uniweb\Library\Cache\Adapter\GregwarCacheAdapter;
use stdClass;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class GregwarCacheAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Uniweb\Library\Cache\Adapter\GregwarCacheAdapter
     */
    protected $cacheAdapter;
    /**
     * Cache könyvtár.
     */
    const DIRECTORY = 'tests/CacheTestDirectory';
    
    public function testSet()
    {
        if (file_exists(self::DIRECTORY)) {
            $this->removeDirectory(self::DIRECTORY);
        }
        mkdir(self::DIRECTORY);
        
        $cache = new Cache(self::DIRECTORY);
        $cache->setPrefixSize(2);
        $adapter = new GregwarCacheAdapter($cache);
        // Beállítja az értéket 3 másodperces élettartammal.
        $adapter->set('key1', 'value', 3);
        // Beállít egy olyan értéket, ami soha nem jár le.
        $adapter->set('key2', 'never expires');
        // Beállít egy értéket 7 másodperces élettartammal.
        $adapter->set('definedKey', 'Here is some text.', 7);
        
        return $adapter;
    }
    /**
     * @param \Uniweb\Library\Cache\Adapter\GregwarCacheAdapter $adapter Adapter
     * @depends testSet
     */
    public function testHas($adapter)
    {
        $this->assertFalse($adapter->has('undefinedKey1'));
        $this->assertFalse($adapter->has('undefinedKey2'));
        $this->assertTrue($adapter->has('key1'));
        $this->assertTrue($adapter->has('key2'));
        $this->assertTrue($adapter->has('definedKey'));
        // 4 másodperces késleltetés.
        sleep(4);
        $this->assertFalse($adapter->has('key1'));
        $this->assertTrue($adapter->has('key2'));
        $this->assertTrue($adapter->has('definedKey'));
        
        return $adapter;
    }
    /**
     * @param \Uniweb\Library\Cache\Adapter\GregwarCacheAdapter $adapter Adapter
     * @depends testHas
     */
    public function testGet($adapter)
    {
        $this->assertNull($adapter->get('undefinedKey'));
        $this->assertEquals('undefinedKey', $adapter->get('undefinedKey', 'undefinedKey'));
        $this->assertEquals('undefinedKey', $adapter->get('undefinedKey', function($cache) {
            return 'undefinedKey';
        }));
        $this->assertInstanceOf(
            '\\Uniweb\\Library\\Cache\\Adapter\\GregwarCacheAdapter', 
            $adapter->get('undefinedKey', function($cache) {
                return $cache;
            })
        );
        
        $this->assertTrue($adapter->has('definedKey'));
        $this->assertTrue(file_exists(self::DIRECTORY . '/d/e/definedKey'));
        $this->assertEquals('Here is some text.', $adapter->get('definedKey'));
        
        sleep(5);
        $this->assertTrue(file_exists(self::DIRECTORY . '/d/e/definedKey'));
        $this->assertEquals('no-no!', $adapter->get('definedKey', function($cache) {
            return 'no-no!';
        }));
        $this->assertFalse(file_exists(self::DIRECTORY . '/d/e/definedKey'));
        
        return $adapter;
    }
    /**
     * @param \Uniweb\Library\Cache\Adapter\GregwarCacheAdapter $adapter Adapter
     * @depends testGet
     */
    public function testRemember($adapter)
    {
        $object1 = new stdClass;
        $object1->key = 'value';
        
        $adapter->remember('object1', $object1, 2);
        $object2 = $adapter->remember('object2', function($cache) {
            $stdClass = new stdClass;
            $stdClass->name = 'Name';
            $stdClass->age = 10;
            return $stdClass;
        });
        
        $this->assertEquals($object1, $adapter->get('object1'));
        $this->assertEquals($object2, $adapter->get('object2'));
        
        sleep(3);
        
        $this->assertEquals('object1', $adapter->get('object1', 'object1'));
        $this->assertEquals($object2, $adapter->get('object2'));
        
        return $adapter;
    }
    /**
     * @param \Uniweb\Library\Cache\Adapter\GregwarCacheAdapter $adapter Adapter
     * @depends testRemember
     */
    public function testDelete($adapter)
    {
        $this->assertTrue($adapter->has('key2'));
        $this->assertTrue($adapter->has('object2'));
        
        $adapter->delete('key2');
        $adapter->delete('object2');
        
        $this->assertFalse($adapter->has('key2'));
        $this->assertFalse($adapter->has('object2'));
        
        $this->removeDirectory(self::DIRECTORY);
    }
    
    private function removeDirectory($directory)
    {
        $dirIterator = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
            if (is_dir($file)) {
                rmdir($file);
            }
        }
        rmdir($directory);
    }
}