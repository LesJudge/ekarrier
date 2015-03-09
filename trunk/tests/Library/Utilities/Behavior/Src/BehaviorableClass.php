<?php
namespace Tests\Uniweb\Library\Utilities\Behavior\Src;
use Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorableInterface;
use Uniweb\Library\Utilities\Behavior\Executive\FilterableMagicCall;
/**
 * @method BehaviorableClass in(string $behavior) Szűrés.
 * @method string method1() Visszatér egy karakterlánccal.
 * @method string method2() Visszatér egy karakterlánccal.
 * @method string apple() Visszatér az 'apple' karakterlánccal.
 * @method string pear() Visszatér a 'pear' karakterlánccal.
 * @method string getPublicProperty() Visszatér a publicProperty értékével.
 * @method string getProtectedProperty() Visszatér a protectedProperty értékével.
 * @method string getPrivateProperty() Visszatér a privateProperty értékével.
 * @method void setPublicProperty(string $publicProperty) Beállítja a publicProperty property értékét.
 * @method void setProtectedProperty(string $protectedProperty) Beállítja a protectedProperty property értékét.
 * @method void setPrivateProperty(string $privateProperty) Beállítja a privateProperty property értékét.
 */
class BehaviorableClass implements BehaviorableInterface
{
    /**
     * @var \Uniweb\Library\Utilities\Behavior\BehaviorContainer
     */
    protected $behaviors;
    /**
     * Publikus property.
     * @var mixed
     */
    public $publicProperty = 'publicProperty';
    /**
     * Védett property.
     * @var mixed
     */
    protected $protectedProperty = 'protectedProperty';
    /**
     * Privát property.
     * @var mixed
     */
    private $privateProperty = 'privateProperty';
    /**
     * Egy újabb publikus property.
     * @var array
     */
    public $beforeSomethings = array();
    
    public function attachBehavior($alias, \Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface $behavior)
    {
        $behavior->setOwner($this);
        $this->behaviors->attachBehavior($alias, $behavior);
    }

    public function detachBehavior($alias)
    {
        $this->behaviors->detachBehavior($alias);
    }
    /**
     * Visszatér a behavior containerrel.
     * @return \Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface
     */
    public function getBehaviorContainer()
    {
        return $this->behaviors;
    }
    /**
     * Beállítja a behavior containert.
     * @param \Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface $container
     */
    public function setBehaviorContainer(\Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface $container)
    {
        $this->behaviors = $container;
    }
    
    public function __call($name, $arguments)
    {
        $executive = new FilterableMagicCall;
        return $executive->executeBehavior($this->behaviors, $name, $arguments);
    }
    /**
     * Hozzáad egy új elemet a beforeSomethings property-hez.
     * @param mixed $beforeSomething Új elem.
     */
    public function addBeforeSomething($beforeSomething)
    {
        $this->beforeSomethings[] = $beforeSomething;
    }
    /**
     * beforeSomething "callback".
     */
    public function beforeSomething()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(true);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function notRequiredCallback()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    /**
     * Visszatér a beforeSomethings property értékével.
     * @return array
     */
    public function getBeforeSomethings()
    {
        return $this->beforeSomethings;
    }
}