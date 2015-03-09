<?php
namespace Uniweb\Library\Utilities\Behavior\Executive;
use Uniweb\Library\Utilities\Behavior\Executive\MagicCall;
use Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface;
use Uniweb\Library\Utilities\Behavior\BehaviorContainer;
use Uniweb\Library\Utilities\Behavior\InvokeReflectionMethod;
use Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException;
use Uniweb\Library\Utilities\Behavior\Exception\ContainerException;
use ReflectionObject;

class FilterableMagicCall extends MagicCall
{
    /**
     * Behavior container.
     * 
     * @var Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface[]
     */
    protected $container;
    /**
     * Behaviorök nevei, ami alapján a szűrés történik.
     * 
     * @var null|string[]
     */
    protected $in = null;
    
    public function __call($name, $arguments)
    {
        $container = $this->container;
        if (!is_null($this->in)) {
            $filtered = new BehaviorContainer;
            foreach ($this->in as $alias) {
                if ($container->hasBehavior($alias)) {
                    if (!$filtered->hasBehavior($alias)) {
                        $filtered->attachBehavior($alias, $container->getBehavior($alias));
                    } else {
                        throw new ExecutiveException('Ezt a behavior-t már használod! (' . $alias . ')');
                    }
                } else {
                    throw new ExecutiveException('A behavior nincs definiálva! (' . $alias. ')');
                }
            }
            $container = $filtered;
        }
        return parent::executeBehavior($container, $name, $arguments);
    }
    /**
     * Beállítja, hogy mely behavior(ök)ben keresse az adott metóudst.
     * @return \Uniweb\Library\Utilities\Behavior\Executive\FilterableMagicCall
     * @throws \Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException
     */
    public function in()
    {
        $arguments = func_get_args();
        foreach ($arguments as $alias) {
            if (!is_string($alias)) {
                throw new ExecutiveException('Nem megfelelő alias!');
            }
        }
        $this->in = $arguments;
        return $this;
    }
    /**
     * Végrehajtja a behavior metódusát.
     * 
     * @param Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface $container
     * @param string $name Behavior neve.
     * @param mixed $arguments Paraméterek
     * @return mixed Metódus visszatérési értéke.
     * @throws Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException
     */
    public function executeBehavior(ContainerInterface $container = null, $name = null, $arguments = null) {
        if (!empty($container)) {
            $this->container = $container;
            $reflectionObject = new ReflectionObject($this);
            if ($reflectionObject->hasMethod($name)) {
                return InvokeReflectionMethod::invoke($reflectionObject->getMethod($name), $this, $arguments);
            } else {
                return $this->__call($name, $arguments);
            }
        } else {
            throw new ExecutiveException('Üres container');
        }
    }
}