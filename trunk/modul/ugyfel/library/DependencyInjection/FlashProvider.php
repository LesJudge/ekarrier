<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;
use Uniweb\Library\Flash\Flash;
use Pimple\ServiceProviderInterface;

class FlashProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['clientFlash'] = $pimple->factory(function($c) {
            return new Flash($_SESSION, 'ugyfelFlash');
        });
    }
}