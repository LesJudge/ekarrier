<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Uniweb\Module\Ugyfel\Controller\XlsExportController;

class XlsExportControllerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['clientXlsExportController'] = $pimple->factory(function($c) {
            return new XlsExportController($c['clientFilter'], $c['clientFlash']);
        });
    }
}