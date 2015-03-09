<?php
namespace Uniweb\Library\Utilities\Behavior\Interfaces;

interface BehaviorInterface
{
    /**
     * Visszatér a behavior "tulajdonosával".
     * @return object A behavior "tulajdonosa".
     */
    public function getOwner();
    /**
     * Beállítja a behavior tulajdonosát.
     * @param object $owner Behavior tulajdonosa.
     * @throws \Uniweb\Library\Utilities\Behavior\Exception\BehaviorException
     */
    public function setOwner($owner);
}