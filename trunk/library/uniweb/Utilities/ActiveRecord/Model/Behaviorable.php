<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Model;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
use Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorableInterface;
use Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface;
use Uniweb\Library\Utilities\Behavior\Executive\FilterableMagicCall;
use ReflectionClass;
use ReflectionObject;

abstract class Behaviorable extends ArBase implements BehaviorableInterface
{
    /**
     * Ez a példányváltozó tárolja a behavior-öket.
     * @var Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface
     */
    protected $behaviors;
    /**
     * Alapértelmezett behavior container osztály neve.
     * 
     * Nagyon csúnya megoldás, mert ezt DI-jal kellett volna megoldani, de már nagyon körülményesnek éreztem.
     * 
     * @var string
     */
    protected $containerClass = '\\Uniweb\\Library\\Utilities\\Behavior\\BehaviorContainer';

    public function after_construct()
    {
        $reflector = new ReflectionClass($this->containerClass);
        if ($reflector->isSubclassOf('\\Uniweb\\Library\\Utilities\\Behavior\\Interfaces\\ContainerInterface')) {
            $this->behaviors = $reflector->newInstanceArgs();
            $behaviors = $this->behaviors();
            if (is_array($behaviors) && !empty($behaviors)) {
                foreach ($behaviors as $alias => $behavior) {
                    /* @var $behavior \Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface */;
                    $this->attachBehavior($alias, $behavior);
                }
            }
            
        } else {
            throw new \Uniweb\Library\Utilities\Behavior\Exception\ContainerException('Nem megfelelő container!');
        }
    }
    /**
     * __get magic metódus felüldeklarálása.
     * @param string $name Property neve.
     * @return mixed
     * @throws \Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException
     * @throws \ActiveRecord\UndefinedPropertyException
     */
    public function &__get($name)
    //public function __get($name)
    {
        $reflector = new ReflectionObject($this);
        $method = 'get_' . $name;
        if ($reflector->hasMethod($method)) {
            return $reflector->getMethod($method)->invoke($this);
        } else {
            try {
                $executive = new FilterableMagicCall;
                return $executive->executeBehavior($this->behaviors, $method);
            } catch (\Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException $ee) {
                return $this->read_attribute($name);
            }
        }
    }
    /**
     * __set magic metódus felüldeklarálása.
     * @param string $name Property neve.
     * @param mixed $value Property értéke.
     * @throws \ActiveRecord\UndefinedPropertyException
     */
    public function __set($name, $value)
    {
        $reflector = new ReflectionObject($this);
        $method = 'set_' . $name;
        if ($reflector->hasMethod($method)) {
            $reflector->getMethod($method)->invoke($this, $value);
        } else {
            try {
                $executive = new FilterableMagicCall;
                $executive->executeBehavior($this->behaviors, $method, $value);
            } catch (\Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException $ee) {
                parent::__set($name, $value);
            }
        }
    }
    /**
     * __call magic metódus felüldeklarálása.
     * @param string $method Metódus neve.
     * @param array $args Metódus paraméterei.
     * @return mixed
     * @throws \ActiveRecord\ActiveRecordException
     */
    public function __call($method, $args)
    {
        try {
            return parent::__call($method, $args);
        } catch (\ActiveRecord\ActiveRecordException $are) {
            try {
                $executive = new FilterableMagicCall;
                return $executive->executeBehavior($this->behaviors, $method, $args);
            } catch (\Uniweb\Library\Utilities\Behavior\Exception\ExecutiveException $ee) {
                throw $are;
            }
        }
    }
    /**
     * Visszatér a modelhez tartozó behavior-ökkel.
     * @return \Uniweb\Library\Utilities\Behavior\Interfaces\BehaviorInterface[] Behavior objektumokat tartalmazó tömb.
     */
    public function behaviors()
    {
        return array();
    }
    
    public function attachBehavior($alias, BehaviorInterface $behavior)
    {
        $behavior->setOwner($this);
        $this->behaviors->attachBehavior($alias, $behavior);
    }
    
    public function detachBehavior($alias)
    {
        $this->behaviors->detachBehavior($alias);
    }
    
    public function before_save()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function before_create()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function before_update()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function before_validation()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function before_validation_on_create()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function before_validation_on_update()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function before_destroy()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function after_save()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function after_create()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function after_update()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function after_validation()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function after_validation_on_create()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function after_validation_on_update()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function after_destroy()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
    }
    
    public function validate()
    {
        $executive = new FilterableMagicCall;
        $executive->setThrowException(false);
        $executive->executeBehavior($this->behaviors, __FUNCTION__);
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
     * @param \Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface $container Behavior container.
     */
    public function setBehaviorContainer(\Uniweb\Library\Utilities\Behavior\Interfaces\ContainerInterface $container)
    {
        $this->behaviors = $container;
    }
}