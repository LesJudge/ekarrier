<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Assign;
use Uniweb\Library\Utilities\ActiveRecord\Interfaces\AssignAttributeInterface;
use ReflectionClass;
use ReflectionException;

abstract class AbstractAssignAttribute implements AssignAttributeInterface
{
    /**
     * ReflectionClass
     * @var null|ReflectionClass
     */
    protected $reflectionClass = null;
    /**
     * Megkeresi a paraméterül adott objektum cél ősét.
     * @param mixed $object Az objektum, aminek megkeresi a cél ősét.
     * @param string $targetClass Cél ős.
     * @return ReflectionClass
     * @throws ReflectionException
     */
    protected function findTargetClass($object, $targetClass)
    {
        $this->reflectionClass = new ReflectionClass($object);
        $parentClass = $this->reflectionClass;
        do {
            $parentClass = $parentClass->getParentClass();
        } while (is_object($parentClass) && $parentClass->getName() != $targetClass);
        if ($parentClass !== false) {
            return $parentClass;
        } else {
            throw new ReflectionException(
                'A cél osztály (\\' . $targetClass . ') nem őse a paraméterül adott objektumnak!'
            );
        }
    }
    /**
     * Végrehajtja a paraméterül adott objektum flag_dirty() metódusát.
     * @param string $name Attribútum neve.
     * @param object $object Objektum, aminek meghívja a flag_dirty() metódusát.
     * @throws ReflectionException
     */
    protected function flagDirty($name, $object)
    {
        $flagDiryMethod = $this->reflectionClass->getMethod('flag_dirty');
        $flagDiryMethod->invoke($object, $name);
    }
    /**
     * Beállítja az attribútum értékét a paraméterül adott objektumon.
     * @param string $name Attribútum neve.
     * @param null|scalar $value Attribútum értéke.
     * @param object $object Objektum, aminek beállítja az értékét.
     * @param boolean $flagDirty Hajtsa-e végre a flag_dirty() metódust a paraméterül adott objektumon.
     * @throws ReflectionException
     */
    protected function setAttributeValue($name, $value, $object, $flagDirty = true)
    {
        if (is_object($object)) {
            $reflectionProperty = $this->findTargetClass($object, 'ActiveRecord\\Model')->getProperty('attributes');
            $reflectionProperty->setAccessible(true);
            // Attribútum értékek felülírása.
            $attributes = $reflectionProperty->getValue($object);
            $attributes[$name] = $value;
            $reflectionProperty->setValue($object, $attributes);
            if ($flagDirty === true) {
                $this->flagDirty($name, $object);
            }
        } else {
            throw new ReflectionException('Nem megfelelő objektum vagy cél osztály!');
        }
    }
    /**
     * Visszatér a ReflectionClass példánnyal, ha az létezik. Ha nem, akkor null-lal.
     * @return null|ReflectionClass
     */
    public function getReflectionClass()
    {
        return $this->reflectionClass;
    }
}