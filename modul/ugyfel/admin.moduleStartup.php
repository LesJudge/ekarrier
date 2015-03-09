<?php
use Uniweb\Library\DependencyInjection\Slim\SlimProvider;
use Uniweb\Module\Ugyfel\Library\DependencyInjection\FilterConfigProvider;
use Uniweb\Module\Ugyfel\Library\DependencyInjection\FlashProvider;
use Uniweb\Module\Ugyfel\Library\DependencyInjection\ClientControllerProvider;
use Uniweb\Module\Ugyfel\Library\DependencyInjection\ClientFilterProvider;
use Uniweb\Module\Ugyfel\Library\DependencyInjection\FilterControllerProvider;
use Uniweb\Module\Ugyfel\Library\DependencyInjection\ProjectControllerProvider;
use Uniweb\Module\Ugyfel\Library\DependencyInjection\PdfExportControllerProvider;
use Uniweb\Module\Ugyfel\Library\DependencyInjection\XlsExportControllerProvider;
use Uniweb\Module\Ugyfel\Library\DependencyInjection\XlsExportConfigProvider;

Rimo::$pimple->register(new SlimProvider);
Rimo::$pimple->register(new FilterConfigProvider);
Rimo::$pimple->register(new FlashProvider);
Rimo::$pimple->register(new ClientFilterProvider);
Rimo::$pimple->register(new ClientControllerProvider);
Rimo::$pimple->register(new FilterControllerProvider);
Rimo::$pimple->register(new ProjectControllerProvider);
Rimo::$pimple->register(new PdfExportControllerProvider);
Rimo::$pimple->register(new XlsExportControllerProvider);
Rimo::$pimple->register(new XlsExportConfigProvider);
// Config hozzáadása a RimoConfig-hoz.
Rimo::__addConfig()->set(array_merge(
    require 'modul/ugyfel/config/ModuleConfig.php',
    require 'modul/ugyfel/config/BaseConfig.php'
));