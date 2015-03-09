<?php
namespace Uniweb\Library\Utilities\Behavior\Executive;
use Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface;
use Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface;
use Uniweb\Library\Utilities\Behavior\Interfaces\ExecutiveInterface;
use Uniweb\Library\Utilities\Behavior\InvokeReflectionMethod;
use Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException;
use ReflectionObject;
use ReflectionMethod;

class MagicCall implements ExecutiveInterface
{
    /**
     * Dobjon-e kivételt, amikor a végrehajtás logikája úgy ítéli meg, hogy ezt kellene tenni.
     * @var boolean
     */
    protected $throwException = true;
    /**
     * Végrehajtja a behavior metódusát.
     * @param Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface $container
     * @param string $name Behavior neve.
     * @param mixed $arguments Paraméterek
     * @return mixed Metódus visszatérési értéke.
     * @throws Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException
     */
    public function executeBehavior(ContainerInterface $container = null, $name = null, $arguments = null)
    {
        $shouldThrowException = true;
        if (!empty($container)) {
            foreach ($container as $behavior) {
                $reflectionObject = new ReflectionObject($behavior);
                if ($reflectionObject->hasMethod($name)) {
                    $method = $reflectionObject->getMethod($name);
                    if ($this->isValidMethod($method)) {
                        $shouldThrowException = false;
                        $returnValue = $this->invokeMethod($method, $behavior, $arguments);
                    }
                    if (!is_null($returnValue)) {
                        return $returnValue;
                    }
                }
            }
        }
        if ($this->throwException && $shouldThrowException) {
            throw new ExecutiveException('Nem található végrehajtható metódus! (' . $name . ')');
        }
    }
    /**
     * Megvizsgálja, hogy a metódus megfelelő-e.
     * @param ReflectionMethod $method Metódus, amit vizsgál.
     * @return boolean
     */
    protected function isValidMethod(ReflectionMethod $method)
    {
        return !$method->isAbstract() && $method->isUserDefined() && $method->isPublic();
    }
    /**
     * Végrehajtja a metódust a paraméterül adott behavior objektumon.
     * @param ReflectionMethod $method Metódus.
     * @param \Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface $behavior Behavior objektum.
     * @param mixed $arguments Paraméterek.
     * @return mixed
     */
    protected function invokeMethod(ReflectionMethod $method, BehaviorInterface $behavior, $arguments = null)
    {
        return InvokeReflectionMethod::invoke($method, $behavior, $arguments);
    }
    
    public function getThrowException()
    {
        return $this->throwException;
    }
    
    public function setThrowException($throwException)
    {
        $this->throwException = $throwException;
    }
}