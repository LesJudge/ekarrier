<?php
namespace Uniweb\Library\DependencyInjection\Smarty;
use Pimple\ServiceProviderInterface;
use Smarty;

class SmartyProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['smarty'] = $pimple->factory(function($c) {
            /* @var $smarty Smarty */
            $smarty = new Smarty;
            //$smarty->caching = true;
            $smarty->compile_dir = 'cache/smarty/compile/';
            $smarty->cache_dir = 'cache/smarty/cache/';
            return $smarty;
        });
    }
}