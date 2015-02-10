<?php
/**
 * Abstract AR Behavior osztály. Az összes ActiveRecord behaviornek ebből az osztályból kell származnia!
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
abstract class ArBehavior
{
    /**
     * Behavior "tulajdonosa".
     * @var \ActiveRecord\Model
     */
    protected $owner;
    /**
     * Hozzárendeli a behavior-t a tulajdonoshoz, valamint beállítja 
     * @param \ActiveRecord\Model $owner Behavior tulajdonosa.
     * @param array $settings Behavior beállításai.
     */
    public function __construct(\ActiveRecord\Model $owner, array $settings = array())
    {
        $this->setOwner($owner);
        if(!empty($settings))
        {
            foreach($settings as $attribute => $value)
            {
                $this->{$attribute} = $value;
            }
        }
    }
    /**
     * Visszatér a példányváltozó értékével, ha az létezik.
     * @param string $name A példányváltozó neve.
     * @return mixed
     * @throws ArBehaviorException
     */
    public function __get($name)
    {
        $methodName = $this->generateMethodName($name, 'get');
        if(method_exists($this, $methodName))
        {
            return call_user_func(array($this, $methodName));
        }
        elseif(isset($this->{$name}))
        {
            return $this->{$name};
        }
        else
        {
            throw new ArBehaviorException("Nincs ilyen attribútum! ({$name})");
        }
    }
    /**
     * Beállítja a példányváltozó értékét, ha az létezik.
     * @param string $name A példányváltozó neve.
     * @param mixed $value A példányváltozó értéke.
     * @return void
     * @throws ArBehaviorException
     */
    public function __set($name, $value)
    {
        $methodName = $this->generateMethodName($name, 'set');
        if(method_exists($this, $methodName))
        {
            call_user_func(array($this, $methodName), $value);
        }
        elseif(isset($this->{$name}))
        {
            $this->{$name} = $value;
        }
        else
        {
            throw new ArBehaviorException("Nincs ilyen attribútum! ({$name})");
        }
    }
    /**
     * Visszatér a példányváltozó getter vagy setter metódusának nevével. <b>(camelCase forma!)</b>
     * @param string $propertyName A példányváltozó neve.
     * @param string $type Getter vagy setter.
     * @return string
     */
    protected function generateMethodName($propertyName, $type)
    {
        return $type.ucfirst($propertyName);
    }
    /**
     * Visszatér a "tulajdonossal".
     * @return \ActiveRecord\Model
     */
    public function getOwner()
    {
        return $this->owner;
    }
    /**
     * Beállítja a behavior tulajdonását.
     * @param \ActiveRecord\Model $owner
     * @return void
     */
    protected function setOwner(\ActiveRecord\Model $owner)
    {
        $this->owner = $owner;
    }
}