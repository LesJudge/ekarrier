<?php
namespace Uniweb\Library\DependencyInjection\Gregwar\Cache;
use Pimple\ServiceProviderInterface;
use ArrayObject;

class Options implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['gregwarCacheOptions'] = $pimple->factory(function($c) {
            $options = new ArrayObject;
            $options->offsetSet('directory', 'cache/data');
            $options->offsetSet('prefixSize', 0);
            return $options;
        });
    }
}