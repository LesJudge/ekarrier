<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\AbstractBehavior;

abstract class ResourceKey extends AbstractBehavior
{
    protected $resourceKeyAttribute;
    
    protected $invalidKeyMessage;

    public function getResourceKeyAttribute()
    {
        return $this->resourceKeyAttribute;
    }
    
    public function getInvalidKeyMessage()
    {
        return $this->invalidKeyMessage;
    }
    
    public function setResourceKeyAttribute($resourceKeyAttribute)
    {
        $this->resourceKeyAttribute = $resourceKeyAttribute;
    }
    
    public function setInvalidKeyMessage($invalidKeyMessage)
    {
        $this->invalidKeyMessage = $invalidKeyMessage;
    }
}