<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\AbstractBehavior;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;
use ActiveRecord\UndefinedPropertyException;

class RecordStatus extends AbstractBehavior
{
    /**
     * Aktív értéket tároló mező neve.
     * @var null|string
     */
    protected $activeAttribute = null;
    /**
     * Törölt értéket tároló mező neve.
     * @var null|string
     */
    protected $deletedAttribute = null;
    /**
     * Aktív mező alapértelmezett értéke.
     * @var int
     */
    protected $defaultActive = 1;
    /**
     * Törölt mező alapértelmezett értéke.
     * @var int
     */
    protected $defaultDeleted = 0;
    
    public function __construct(
        $activeAttribute = null, 
        $deletedAttribute = null, 
        $defaultActive = 1, 
        $defaultDeleted = 0
    ) {
        $this->activeAttribute = $activeAttribute;
        $this->deletedAttribute = $deletedAttribute;
        $this->defaultActive = $defaultActive;
        $this->defaultDeleted = $defaultDeleted;
    }
    /**
     * Beállítja az alapértelmezett aktív értéket.
     */
    public function before_create()
    {
        if (!is_null($this->activeAttribute) && !$this->owner->attribute_is_dirty($this->activeAttribute)) {
            $this->setStatus($this->activeAttribute, $this->defaultActive);
        }
        if (!is_null($this->deletedAttribute) && !$this->owner->attribute_is_dirty($this->deletedAttribute)) {
            $this->setStatus($this->deletedAttribute, $this->defaultDeleted);
        }
    }
    
    public function get_aktiv()
    {
        return $this->getStatus($this->activeAttribute);
    }
    
    public function get_torolt()
    {
        return $this->getStatus($this->deletedAttribute);
    }
    
    public function set_aktiv($aktiv)
    {
        $this->setStatus($this->activeAttribute, $aktiv);
    }
    
    public function set_torolt($torolt)
    {
        $this->setStatus($this->deletedAttribute, $torolt);
    }
    /**
     * Validálja a mező aktív értékét.
     */
    public function validate()
    {
        $isValid = function($value) {
            return is_int($value) && ($value == 0 || $value == 1);
        };
        if (!is_null($this->activeAttribute)) {
            $active = $this->owner->read_attribute($this->activeAttribute);
            if (!is_null($active) && !$isValid($active)) {
                $this->owner->errors->add($this->activeAttribute, 'Az aktív mező értéke nem megfelelő! (0-1)');
            }
        }
        if (!is_null($this->deletedAttribute)) {
            $deleted = $this->owner->read_attribute($this->deletedAttribute);
            if (!is_null($deleted) && !$isValid($deleted)) {
                $this->owner->errors->add($this->deletedAttribute, 'A törölt mező értéke nem megfelelő! (0-1)');
            }
        }
    }
    /**
     * Visszatér a paraméterül adott státusz értékével.
     * @return int
     */
    public function getStatus($property)
    {
        if (!is_null($property)) {
            return $this->owner->read_attribute($property);
        }
        throw new UndefinedPropertyException(get_class($this->owner), 'status');
    }
    /**
     * Beállítja az attribútum értékét.
     * @param string $property Attribútum neve.
     */
    public function setStatus($property, $value)
    {
        if (!is_null($property)) {
            $assign = new WithoutCast;
            $assign->assignAttribute($property, $value, $this->owner, true);
        } else {
            throw new UndefinedPropertyException(get_class($this->owner), 'status');
        }
    }
    /**
     * Visszatér a rekord aktív értékét tároló attribútum nevével.
     * @return null|string
     */
    public function getActiveAttribute()
    {
        return $this->activeAttribute;
    }
    /**
     * Visszatér a rekord törölt értékét tároló attribútum nevével.
     * @return null|string
     */
    public function getDeletedAttribute()
    {
        return $this->deletedAttribute;
    }
    
    public function getDefaultActive()
    {
        return $this->defaultActive;
    }
    
    public function getDefaultDeleted()
    {
        return $this->defaultDeleted;
    }
    /**
     * Beállítja a rekord aktív értékét tároló attribútumot.
     * @param null|string $activeAttribute Attribútum neve.
     */
    public function setStatusAttribute($activeAttribute)
    {
        $this->activeAttribute = $activeAttribute;
    }
    /**
     * Beállítja a rekord törölt értékét tároló attribútumot.
     * @param null|string $deletedAttribute Attribútum neve.
     */
    public function setDeletedAttribute($deletedAttribute)
    {
        $this->deletedAttribute = $deletedAttribute;
    }
    
    public function setDefaultActive($defaultActive)
    {
        $this->defaultActive = $defaultActive;
    }
    
    public function setDefaultDeleted($defaultDeleted)
    {
        $this->defaultDeleted = $defaultDeleted;
    }
}