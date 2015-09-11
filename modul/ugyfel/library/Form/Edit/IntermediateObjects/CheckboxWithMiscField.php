<?php
namespace Uniweb\Module\Ugyfel\Library\Form\Edit\IntermediateObjects;

use Uniweb\Library\Form\Interfaces\IntermediateObjectInterface;

class CheckboxWithMiscField implements IntermediateObjectInterface
{
    private $recordId;
    
    private $id;
    
    private $name;
    
    private $hasField;
    
    private $checked;
    
    private $misc;
    
    private $object;
    
    public function __construct($recordId, $id, $name, $hasField, $checked, $misc, $object)
    {
        $this->recordId = $recordId;
        $this->id = $id;
        $this->name = $name;
        $this->hasField = $hasField;
        $this->checked = $checked;
        $this->misc = $misc;
        $this->object = $object;
    }
    
    public function getRecordId()
    {
        return $this->recordId;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getHasField()
    {
        return $this->hasField;
    }

    public function getChecked()
    {
        return $this->checked;
    }

    public function getMisc()
    {
        return $this->misc;
    }
    
    public function getObject()
    {
        return $this->object;
    }
}