<?php
namespace Uniweb\Library\Utilities\Behavior;
use Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface;

abstract class AbstractBehavior implements BehaviorInterface
{
    /**
     * Behavior tulajdonosa.
     * @var object
     */
    protected $owner;
    /**
     * Visszatér a behavior tulajdonosával.
     * @return object
     */
    public function getOwner()
    {
        return $this->owner;
    }
    /**
     * Beállítja a behavior tulajdonosát.
     * @param object $owner Behavior tulajdonosa.
     * @throws \Uniweb\Library\Utilities\Behavior\Exception\BehaviorException
     */
    public function setOwner($owner)
    {
        if (is_object($owner)) {
            $this->owner = $owner;
        } else {
            throw new \Uniweb\Library\Utilities\Behavior\Exception\BehaviorException('Nem megfelelő tulajdonos!');
        }
    }
}