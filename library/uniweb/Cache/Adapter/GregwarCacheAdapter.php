<?php
namespace Uniweb\Library\Cache\Adapter;

use Gregwar\Cache\Cache;
use Gregwar\Cache\GarbageCollect;
use Uniweb\Library\Cache\CacheInterface;

class GregwarCacheAdapter implements CacheInterface
{
    /**
     *
     * @var Cache
     */
    private $cache;
    
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }
    
    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        $gc = new GarbageCollect;
        $filename = $this->cache->getCacheFile($key);
        $gc->drop($filename);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        $item = $this->cache->get($key);
        if (!is_null($item)) {
            $data = unserialize($item);
            if (time() < $data[0] || $data[0] === 0) {
                return $data[1];
            } else {
                $this->delete($key);
            }
        }
        return $this->processDefault($default);
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return !is_null($this->get($key));
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $ttl = 0)
    {
        $lifetime = $ttl === 0 ? 0 : time() + (int)$ttl;
        $cacheItem = array(0 => $lifetime, 1 => $value);
        $this->cache->set($key, serialize($cacheItem));
    }
    
    /**
     * {@inheritdoc}
     */
    public function remember($key, $value, $ttl = 0)
    {
        $item = $this->get($key);
        if (is_null($item)) {
            $data = $this->processDefault($value);
            $this->set($key, $data, $ttl);
            return $data;
        }
        return $item;
    }
    
    private function processDefault($default)
    {
        if (is_callable($default)) {
            return call_user_func($default, $this);
        }
        return $default;
    }
}