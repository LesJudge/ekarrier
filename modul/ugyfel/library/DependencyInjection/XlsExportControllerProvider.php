<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;
use Uniweb\Module\Ugyfel\Controller\XlsExportController;
use Pimple\ServiceProviderInterface;

class XlsExportControllerProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['clientXlsExportController'] = $pimple->factory(function($c) {
            return new XlsExportController($c['clientFilter'], $c['clientFlash']);
        });
    }
}