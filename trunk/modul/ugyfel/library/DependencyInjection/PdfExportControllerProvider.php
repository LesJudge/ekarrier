<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Uniweb\Module\Ugyfel\Controller\PdfExportController;
use Pimple\ServiceProviderInterface;

class PdfExportControllerProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['clientPdfExportController'] = $pimple->factory(function($c) {
            return new PdfExportController(new ClientRepository);
        });
    }
}