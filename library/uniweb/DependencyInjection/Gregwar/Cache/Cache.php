<?php
namespace Uniweb\Library\DependencyInjection\Gregwar\Cache;

use ArrayObject;
use Gregwar\Cache\Cache;
use Gregwar\Cache\Cache as GregwarCache;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Cache implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['gregwarCache'] = $pimple->factory(function($c) {
            /* @var $options ArrayObject */
            $options = $c['gregwarCacheOptions'];
            /* @var $cache Cache */
            $cache = new GregwarCache($options->offsetGet('directory'));
            $cache->setPrefixSize($options->offsetGet('prefixSize'));
            return $cache;
        });
    }
}