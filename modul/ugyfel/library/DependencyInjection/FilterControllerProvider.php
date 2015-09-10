<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Uniweb\Module\Ugyfel\Controller\FilterController;

class FilterControllerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['clientFilterController'] = $pimple->factory(function($c) {
            return new FilterController($c['clientFilter'], $c['clientFlash']);
        });
    }
}