<?php
namespace Uniweb\Module\Ugyfel\Library\DependencyInjection;
use Pimple\ServiceProviderInterface;

class FilterConfigProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['clientFilterConfig'] = $pimple->factory(function($c) {
            return require 'modul/ugyfel/config/FilterConfig.php';
        });
    }
}