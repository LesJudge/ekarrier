<?php
namespace Uniweb\Library\DependencyInjection\Gregwar\Cache;

use ArrayObject;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Options implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['gregwarCacheOptions'] = $pimple->factory(function($c) {
            $options = new ArrayObject;
            $options->offsetSet('directory', 'cache/data');
            $options->offsetSet('prefixSize', 0);
            return $options;
        });
    }
}