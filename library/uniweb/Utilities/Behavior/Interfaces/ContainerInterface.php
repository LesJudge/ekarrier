<?php
namespace Uniweb\Library\Utilities\Behavior\Interfaces;
use Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface;
use IteratorAggregate;
use Countable;

interface ContainerInterface extends IteratorAggregate, Countable
{
    /**
     * Visszatér a behaviorrel, ha az létezik. Ha a behavior nem létezik, akkor kivételt dob!
     * @param string $alias Behavior neve.
     * @return Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface Behavior objektum.
     * @throws Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     */
    public function getBehavior($alias);
    /**
     * Megvizsgálja, hogy létezik-e a kért behavior.
     * @param string $alias Behavior neve.
     * @return boolean Létezik-e a behavior.
     */
    public function hasBehavior($alias);
    /**
     * Csatolja a behavior-t.
     * @param string $alias Behavior neve.
     * @param Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface $behavior Behavior objektum.
     * @throws Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     */
    public function attachBehavior($alias, BehaviorInterface $behavior);
    /**
     * Törli a paraméterül adott behaviort, ha az létezik. Ha nem, akkor kivételt dob!
     * @param string $alias Behavior neve.
     * @throws Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     */
    public function detachBehavior($alias);
}