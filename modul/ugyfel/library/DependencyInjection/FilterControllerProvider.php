<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;
use Uniweb\Module\Ugyfel\Controller\FilterController;
use Pimple\ServiceProviderInterface;

class FilterControllerProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['clientFilterController'] = $pimple->factory(function($c) {
            return new FilterController($c['clientFilter'], $c['clientFlash']);
        });
    }
}