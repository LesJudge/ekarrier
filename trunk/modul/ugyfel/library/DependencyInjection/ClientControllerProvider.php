<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Uniweb\Module\Ugyfel\Controller\ClientController;
use Pimple\ServiceProviderInterface;

class ClientControllerProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['clientController'] = $pimple->factory(function($c) {
            //return new ClientController(new ClientRepository, new Flash($_SESSION, 'ugyfelFlash'));
            return new ClientController($c['clientFilter'], $c['clientFlash'], new ClientRepository);
        });
    }
}