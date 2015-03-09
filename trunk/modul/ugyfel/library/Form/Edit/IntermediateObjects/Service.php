<?php
namespace Uniweb\Module\Ugyfel\Library\Form\Edit\IntermediateObjects;
use Uniweb\Library\Form\Interfaces\IntermediateObjectInterface;

class Service implements IntermediateObjectInterface
{
    protected $recordId;
    /**
     * Szolgáltatás azonosító.
     * @var int
     */
    protected $id;
    /**
     * Szolgáltatás neve.
     * @var string
     */
    protected $name;
    /**
     * Kiválasztott-e az ügyfél.
     * @var boolean
     */
    protected $checked;
    /**
     * Részt akar-e venni a szolgáltatáson.
     * @var boolean
     */
    protected $wantToParticipate;
    /**
     * Részt vett a szolgáltatáson.
     * @var boolean
     */
    protected $attended;
    /**
     * Mikor vett részt a szolgáltatáson.
     * @var mixed
     */
    protected $when;
    
    protected $object;
    
    public function __construct($recordId, $id, $name, $checked, $wantToParticipate, $attended, $when, $object)
    {
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