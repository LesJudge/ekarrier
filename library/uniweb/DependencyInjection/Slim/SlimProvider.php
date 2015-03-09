<?php
namespace Uniweb\Library\DependencyInjection\Slim;
use Pimple\ServiceProviderInterface;
use Slim\Slim;

class SlimProvider implements ServiceProviderInterface
{
    public function register(\Pimple\Container $pimple)
    {
        $pimple['slim'] = $pimple->factory(function($c) {
            return new Slim(array(
                'debug' => false,
                'cookies.secret_key' => '?@w*3@SBq@uPzs-2L_DzURzR=AYS8RF&7C!a6q#6hD2C33M#ut5BmGc!XdNNWL$%'
            ));
        });
    }
}