<?php
namespace Uniweb\Library\DependencyInjection\Gregwar\Cache;
use Pimple\ServiceProviderInterface;
use Gregwar\Cache\Cache as GregwarCache;

class Cache implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['gregwarCache'] = $pimple->factory(function($c) {
            /* @var $options \ArrayObject */
            $options = $c['gregwarCacheOptions'];
            /* @var $cache \Gregwar\Cache\Cache */
            $cache = new GregwarCache($options->offsetGet('directory'));
            $cache->setPrefixSize($options->offsetGet('prefixSize'));
            return $cache;
        });
    }
}