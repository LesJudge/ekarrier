<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\AbstractBehavior;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast;
use Uniweb\Library\Utilities\ActiveRecord\Assign\DateTime;
use Uniweb\Library\Utilities\ActiveRecord\Validator\Timestamp as TimestampValidator;
use ActiveRecord\UndefinedPropertyException;
/**
 * Az időbélyeg behavior használatával automatikusan frissül a létrehozás és módosítás idejét tároló mező értéke, 
 * vagy valamelyiké a kettő közül. Ez attól függ, hogyan csatoljuk a behavior-t a modelhez. A használni nem kívánt 
 * mező neve kapjon null értéket, így figyelmen kívül hagyja a mentés során.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Timestamp extends AbstractBehavior
{
    /**
     * A létrehozás idejét tároló mező neve.
     * @var null|string
     */
    protected $createdAttribute = null;
    /**
     * A módosítás idejét tároló mező neve.
     * @var null|string
     */
    protected $modifiedAttribute = null;
    /**
     * 
     * @param null|string $createdAttribute Létrehozás idejét tároló attribútum neve.
     * @param null|string $modifiedAttribute Módosítás idejét tároló attribútum neve.
     */
    public function __construct(
        $createdAttribute = null,
        $modifiedAttribute = null
    ) {
        $this->createdAttribute = $createdAttribute;
        $this->modifiedAttribute = $modifiedAttribute;
    }
    /**
     * Új rekord mentése előtt lefutó metódus.
     */
    public function before_create()
    {
        if (!is_null($this->createdAttribute) && !$this->owner->attribute_is_dirty($this->createdAttribute)) {
            $this->set_letrehozas_timestamp(date(\ActiveRecord\DateTime::$FORMATS['db']));
        }
    }
    /**
     * Létező rekord módosítása előtt lefutó metódus.
     */
    public function before_update()
    {
        if (!is_null($this->modifiedAttribute) && !$this->owner->attribute_is_dirty($this->modifiedAttribute)) {
            $this->set_modositas_timestamp(date(\ActiveRecord\DateTime::$FORMATS['db']));
        }
    }
    /**
     * Validálja az attribútumokat.
     */
    public function validate()
    {
        $validator = new TimestampValidator(true);
        if (!is_null($this->createdAttribute)) {
            if (!$validator->validate($this->get_letrehozas_timestamp())) {
                $this->owner->errors->add(
                    $this->createdAttribute, 'A létrehozás ideje nem megfelelő! (éééé-hh-nn óó:pp:mm)'
                );
            }
        }
        if (!is_null($this->modifiedAttribute)) {
            if (!$validator->validate($this->get_modositas_timestamp())) {
                $this->owner->errors->add(
                    $this->modifiedAttribute, 'A módosítás ideje nem megfelelő! (éééé-hh-nn óó:pp:mm)'
                );
            }
        }
    }
    /**
     * Visszatér a létrehozás idejével.
     * @return false|\ActiveRecord\DateTime
     */
    public function get_letrehozas_timestamp()
    {
        return $this->getTimestamp($this->createdAttribute);
    }
    /**
     * Visszatér a módosítás idejével.
     * @return false|\ActiveRecord\DateTime
     */
    public function get_modositas_timestamp()
    {
        return $this->getTimestamp($this->modifiedAttribute);
    }
    /**
     * Beállítja a létrehozás idejét.
     * @param mixed $letrehozas_timestamp Létrehozás ideje.
     */
    public function set_letrehozas_timestamp($letrehozas_timestamp)
    {
        $this->setTimestamp($this->createdAttribute, $letrehozas_timestamp);
    }
    /**
     * Beállítja a módosítás idejét.
     * @param mixed $modositas_timestamp Módosítás ideje.
     */
    public function set_modositas_timestamp($modositas_timestamp)
    {
        $this->setTimestamp($this->modifiedAttribute, $modositas_timestamp);
    }
    /**
     * Kiolvassa az attribútum értékét.
     * @param string $property Attribútum neve.
     * @return null\false|\ActiveRecord\Datetime
     * @throws \ActiveRecord\UndefinedPropertyException
     */
    protected function getTimestamp($property)
    {
        if (!is_null($property)) {
            return $this->owner->read_attribute($property);
        } else {
            throw new UndefinedPropertyException(get_class($this->owner), 'timestamp');
        }
    }
    /**
     * Beállítja a paraméterül adott mező időbélyegét. (Csak akkor, ha a mező neve nem null!)
     * @param string $property Típus.
     * @param mixed $value Érték.
     * @throws \ActiveRecord\UndefinedPropertyException
     */
    protected function setTimestamp($property, $value)
    {
        if (!is_null($property)) {
            if (is_null($value)) {
                $dirty = false;
                $assign = new WithoutCast;
            } else {
                $dirty = true;
                $assign = new DateTime(\ActiveRecord\DateTime::$FORMATS['db']);
            }
            $assign->assignAttribute($property, $value, $this->owner, $dirty);
        } else {
            throw new UndefinedPropertyException(get_class($this->owner), 'timestamp');
        }
    }
    /**
     * Visszatér a létrehozás idejét tároló mező nevével.
     * @return null|string
     */
    public function getCreatedAttribute()
    {
        return $this->createdAttribute;
    }
    /**
     * Visszatér a módosítás idejét tároló mező nevével.
     * @return null|string
     */
    public function getModifiedAttribute()
    {
        return $this->modifiedAttribute;
    }
    /**
     * Beállítja a létrehozás ideje attribútumot.
     * @param string $createdAttribute Létrehozás ideje attribútum.
     */
    public function setCreatedAttribute($createdAttribute)
    {
        $this->createdAttribute = $createdAttribute;
    }
    /**
     * Beállítja a módosítás ideje attribútumot.
     * @param string $modifiedAttribute Módosítás ideje attribútum.
     */
    public function setModifiedAttribute($modifiedAttribute)
    {
        $this->modifiedAttribute = $modifiedAttribute;
    }
}