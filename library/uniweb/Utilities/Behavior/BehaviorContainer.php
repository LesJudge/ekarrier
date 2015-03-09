<?php
namespace Uniweb\Library\Utilities\Behavior;
use Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface;
use Uniweb\Library\Utilities\Behavior\Exception\ContainerException;
use Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface;
use ArrayAccess;
use ArrayIterator;

class BehaviorContainer implements ContainerInterface, ArrayAccess
{
    /**
     * Behavior tömb.
     * @var \Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface[]
     */
    protected $behaviors = array();
    /**
     * Visszatér a behaviorrel, ha az létezik. Ha a behavior nem létezik, akkor kivételt dob!
     * @param string $alias Behavior neve.
     * @return Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface Behavior objektum.
     * @throws Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     */
    public function getBehavior($alias)
    {
        if ($this->hasBehavior($alias)) {
            return $this->behaviors[$alias];
        }
        throw new ContainerException('A keresett behavior (' . $alias . ') nem létezik!');
    }
    /**
     * Megvizsgálja, hogy létezik-e a kért behavior.
     * @param string $alias Behavior neve.
     * @return boolean Létezik-e a behavior.
     */
    public function hasBehavior($alias)
    {
        return isset($this->behaviors[$alias]);
    }
    /**
     * Csatolja a behavior-t.
     * @param string $alias Behavior neve.
     * @param Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface $behavior Behavior objektum.
     * @throws Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     */
    public function attachBehavior($alias, Interfaces\BehaviorInterface $behavior)
    {
        if (!$this->hasBehavior($alias)) {
            $this->behaviors[$alias] = $behavior;
        } else {
            throw new ContainerException('A/az (' . $alias . ') nevű behavior már létezik!');
        }
    }
    /**
     * Törli a paraméterül adott behaviort, ha az létezik. Ha nem, akkor kivételt dob!
     * @param string $alias Behavior neve.
     * @throws Uniweb\Library\Utilities\Behavior\Exception\ContainerException
     */
    public function detachBehavior($alias)
    {
        if ($this->hasBehavior($alias)) {
            unset($this->behaviors[$alias]);
        } else {
            throw new ContainerException('A keresett behavior (' . $alias . ') nem létezik!');
        }
    }
    
    public function offsetExists($offset)
    {
        return $this->hasBehavior($offset);
    }

    public function offsetGet($offset)
    {
        return $this->getBehavior($offset);
    }

    public function offsetSet($offset, $value)
    {
        if (is_object($value) && $value instanceof BehaviorInterface) {
            $this->attachBehavior($offset, $value);
        } else {
            throw new ContainerException('A paraméterül adott érték nem Behavior objektum!');
        }
    }

    public function offsetUnset($offset)
    {
        $this->detachBehavior($offset);
    }
    
    public function count($mode = COUNT_NORMAL)
    {
        return count($this->behaviors, $mode);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->behaviors);
    }
}