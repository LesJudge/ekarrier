<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class XlsExportConfigProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['clientXlsExportConfig'] = $pimple->factory(function($c) {
            return require 'modul/ugyfel/config/XlsExportConfig.php';
        });
    }
}