<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Uniweb\Module\Ugyfel\Controller\ClientController;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;

class ClientControllerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['clientController'] = $pimple->factory(function($c) {
            return new ClientController($c['clientFilter'], $c['clientFlash'], new ClientRepository);
        });
    }
}