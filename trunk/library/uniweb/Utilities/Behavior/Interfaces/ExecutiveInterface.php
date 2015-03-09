<?php
namespace Uniweb\Library\Utilities\Behavior\Interfaces;
use Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface;

interface ExecutiveInterface
{
    /**
     * Végrehajtja a behavior metódusát.
     * @param Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface $container
     * @param string $name Behavior neve.
     * @param mixed $arguments Paraméterek
     * @return mixed Metódus visszatérési értéke.
     * @throws Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException
     */
    public function executeBehavior(ContainerInterface $container = null, $name = null, $arguments = null);
}