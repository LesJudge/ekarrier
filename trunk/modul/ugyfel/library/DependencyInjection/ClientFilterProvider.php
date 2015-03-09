<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;
use Uniweb\Module\Ugyfel\Library\DynamicFilter\Client as ClientFilter;
use Uniweb\Library\DynamicFilter\Persistence\Session as SessionPersistence;
use Pimple\ServiceProviderInterface;

class ClientFilterProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['clientFilter'] = $pimple->factory(function($c) {
            return new ClientFilter(new SessionPersistence($_SESSION));
        });
    }
}