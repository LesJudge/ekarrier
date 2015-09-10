<?php
namespace Uniweb\Library\DependencyInjection\Gregwar\Cache;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Uniweb\Library\Cache\Adapter\GregwarCacheAdapter;

class Adapter implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['gregwarCacheAdapter'] = $pimple->factory(function($c) {
            return new GregwarCacheAdapter($c['gregwarCache']);
        });
    }
}