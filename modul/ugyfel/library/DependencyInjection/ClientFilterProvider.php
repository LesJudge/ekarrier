<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Uniweb\Library\DynamicFilter\Persistence\Session as SessionPersistence;
use Uniweb\Module\Ugyfel\Library\DynamicFilter\Client as ClientFilter;

class ClientFilterProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['clientFilter'] = $pimple->factory(function($c) {
            return new ClientFilter(new SessionPersistence($_SESSION));
        });
    }
}