<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Uniweb\Module\Ugyfel\Controller\ProjectController;

class ProjectControllerProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['clientProjectController'] = $pimple->factory(function($c) {
            return new ProjectController($c['clientFilter'], $c['clientFlash']);
        });
    }
}