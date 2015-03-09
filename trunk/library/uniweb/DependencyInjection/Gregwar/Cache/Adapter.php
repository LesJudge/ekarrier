<?php
namespace Uniweb\Library\DependencyInjection\Gregwar\Cache;
use Uniweb\Library\Cache\Adapter\GregwarCacheAdapter;
use Pimple\ServiceProviderInterface;

class Adapter implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['gregwarCacheAdapter'] = $pimple->factory(function($c) {
            return new GregwarCacheAdapter($c['gregwarCache']);
        });
    }
}