<?php
namespace Uniweb\Module\Ugyfel\Library\Form\Edit\IntermediateObjects;

use Uniweb\Library\Form\Interfaces\IntermediateObjectInterface;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\ServiceInterested;

class Service implements IntermediateObjectInterface
{
    /**
     * Rekord azonosító.
     * 
     * @var int
     */
    private $recordId;
    
    /**
     * Szolgáltatás azonosító.
     * 
     * @var int
     */
    private $id;
    
    /**
     * Szolgáltatás neve.
     * 
     * @var string
     */
    private $name;
    
    /**
     * Kiválasztott-e az ügyfél.
     * 
     * @var boolean
     */
    private $checked;
    
    /**
     * Részt akar-e venni a szolgáltatáson.
     * 
     * @var boolean
     */
    private $wantToParticipate;
    
    /**
     * Részt vett a szolgáltatáson.
     * 
     * @var boolean
     */
    private $attended;
    
    /**
     * Mikor vett részt a szolgáltatáson.
     * 
     * @var mixed
     */
    private $when;
    
    /**
     * Ügyfél által érdekelt szolgáltatás objektum.
     * 
     * @var ServiceInterested
     */
    private $object;
    
    public function __construct(
        $recordId, 
        $id, 
        $name, 
        $checked, 
        $wantToParticipate, 
        $attended, 
        $when, 
        ServiceInterested $object
    ) {
        $this->recordId = $recordId;
        $this->id = $id;
        $this->name = $name;
        $this->checked = $checked;
        $this->wantToParticipate = $wantToParticipate;
        $this->attended = $attended;
        $this->when = $when;
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
    
    public function getChecked()
    {
        return $this->checked;
    }

    public function getWantToParticipate()
    {
        return $this->wantToParticipate;
    }

    public function getAttended()
    {
        return $this->attended;
    }
    /**
     * 
     * @return mixed
     */
    public function getWhen()
    {
        return $this->when;
    }
    
    public function getObject()
    {
        return $this->object;
    }
}