<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Model;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * Típustól függő model.
 * 
 */
abstract class TypeDependent extends ArBase
{
    /**
     * Attribútum, ami meghatározza a típust.
     * @var string
     */
    protected static $attribute;
    /**
     * @return Uniweb\Library\Utilities\ActiveRecord\Interfaces\AttributeModifierInterface Módosító objektum.
     */
    abstract public static function instantiateModifier();
    /**
     * @return int Visszatér a típus azonosítóval.
     */
    abstract public static function typeId();
    
    public function before_save()
    {
        $this->{static::getAttribute()} = static::typeId();
    }
    
    public static function delete_all($options = array())
    {
        $modifier = static::instantiateModifier();
        $modifier->modifyAttributes($options);
        parent::delete_all($options);
    }
    
    public static function update_all($options = array())
    {
        $modifier = static::instantiateModifier();
        $modifier->modifyAttributes($options);
        parent::update_all($options);
    }
    
    public static function count()
    {
        $args = func_get_args();
        if (is_array($args) && array_key_exists(0, $args)) {
            $options = $args[0];
        } else {
            $options = array('conditions' => array());
        }
        $modifier = static::instantiateModifier();
        $modifier->modifyAttributes($options);
        return parent::count($options);
    }
    
    public static function find()
    {
        $args = func_get_args();        
        if (is_array($args) && array_key_exists(0, $args)) {
            $options = array();
            if (array_key_exists(1, $args) && is_array($args[1])) {
                $options = $args[1];
            }
            if (!array_key_exists('conditions', $options)) {
                $options['conditions'] = array();
            }
            $modifier = static::instantiateModifier();
            $modifier->modifyAttributes($options);
            
            
            //echo '<pre>', print_r($options, true), '</pre>';
            //exit;
            
            return call_user_func_array('parent::find', array($args[0], $options));
        }
        return call_user_func('parent::find');
    }
    
    public static function pk_conditions($args)
    {
        $conditions = parent::pk_conditions($args);
        $attribute = static::getAttribute();
        $typeId = static::typeId();
        if (is_array($args)) {
            $count = count($args);
            $conditions[$attribute] = array();
            for ($i = 0; $i < $count; $i++) {
                $conditions[$attribute][$i] = $typeId;
            }
        } else {
            $conditions[$attribute] = $typeId;
        }
        return $conditions;
    }
    /**
     * Visszatér az attribútum nevével, ami meghatározza a típust.
     * @return string
     */
    public static function getAttribute()
    {
        return static::$attribute;
    }
}