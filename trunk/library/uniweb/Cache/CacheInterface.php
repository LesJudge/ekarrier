<?php
namespace Uniweb\Library\Cache;

interface CacheInterface
{
    public function get($key, $default = null);
    
    public function set($key, $value, $ttl = 0);
    
    public function has($key);
    
    public function delete($key);
    
    public function remember($key, $value, $ttl = 0);
}