<?php
namespace Uniweb\Library\Utilities\Behavior\Interfaces;
use Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface;
use Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface;

interface BehaviorableInterface
{
    /**
     * Visszatér a behavior containerrel.
     * @return \Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface Container objektum.
     */
    public function getBehaviorContainer();
    /**
     * Beállítja a container objektumot.
     * @param \Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface $container Container objektum.
     */
    public function setBehaviorContainer(ContainerInterface $container);
    /**
     * Csatolja a behavior-öket az objektumhoz.
     */
    public function attachBehavior($alias, BehaviorInterface $behavior);
    /**
     * Leválasztja a behavior-öket az objektumról.
     */
    public function detachBehavior($alias);
}