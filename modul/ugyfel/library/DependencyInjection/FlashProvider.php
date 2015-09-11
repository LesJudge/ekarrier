<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Uniweb\Library\Flash\Flash;

class FlashProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['clientFlash'] = $pimple->factory(function($c) {
            return new Flash($_SESSION, 'ugyfelFlash');
        });
    }
}