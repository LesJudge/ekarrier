<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;
use Uniweb\Module\Ugyfel\Controller\ProjectController;
use Pimple\ServiceProviderInterface;

class ProjectControllerProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['clientProjectController'] = $pimple->factory(function($c) {
            return new ProjectController($c['clientFilter'], $c['clientFlash']);
        });
    }
}