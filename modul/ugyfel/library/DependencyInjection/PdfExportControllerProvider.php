<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Uniweb\Module\Ugyfel\Controller\PdfExportController;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;

class PdfExportControllerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['clientPdfExportController'] = $pimple->factory(function($c) {
            return new PdfExportController(new ClientRepository);
        });
    }
}