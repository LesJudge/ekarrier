<?php
namespace Uniweb\Module\Ugyfel\Library\Form\Edit\IntermediateObjects;

use Uniweb\Library\Form\Interfaces\IntermediateObjectInterface;
use Uniweb\Module\Szolgaltatas\Model\ActiveRecord\Service as ServiceModel;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\ServiceInterested;

/**
 * Description of Service
 *
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Service implements IntermediateObjectInterface
{
    /**
     * @var ServiceModel
     */
    private $service;
    
    /**
     * @var ServiceInterested|null
     */
    private $selected;
    
    public function __construct(ServiceModel $service, ServiceInterested $selected = null)
    {
        $this->service = $service;
        $this->selected = $selected;
    }
    
    /**
     * Visszatér az érdekelt szolgáltatás azonosítójával.
     * 
     * @return int
     */
    public function getRecordId()
    {
        if ($this->isSelected()) {
            return $this->selected->ugyfel_attr_szolgaltatas_erdekelt_id;
        }
        
        return null;
    }
    
    /**
     * Visszatér a szolgáltatás azonosítójával.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->service->szolgaltatas_id;
    }

    /**
     * Visszatér a szolgáltatás nevével.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->service->nev;
    }
    
    /**
     * Kiválasztotta-e a szolgáltatást.
     * 
     * @return bool
     */
    public function getChecked()
    {
        return $this->isSelected();
    }

    /**
     * Részt akar-e venni a szolgáltatáson.
     * 
     * @return int|null
     */
    public function getWantToParticipate()
    {
        if ($this->isSelected()) {
            return $this->selected->reszt_akar_venni;
        }
        
        return null;
    }

    /**
     * Részt vett-e a szolgáltatáson.
     * 
     * @return int|null
     */
    public function getAttended()
    {
        if ($this->isSelected()) {
            return $this->selected->reszt_vett;
        }
        
        return null;
    }
    
    /**
     * Mikor vett részt a szolgáltatáson.
     * 
     * @return string|null
     */
    public function getWhen()
    {
        if ($this->isSelected()) {
            return $this->selected->mikor;
        }
        
        return null;
    }
    
    /**
     * Visszatér a szolgáltatás objektummal.
     * 
     * @return ServiceModel
     */
    public function getService()
    {
        return $this->service;
    }
    
    /**
     * Visszatér a kiválasztott szolgáltatás objektummal.
     * 
     * @return ServiceInterested
     */
    public function getSelected()
    {
        return $this->selected;
    }
    
    /**
     * Ki van-e választva a szolgáltatás.
     * 
     * @return bool
     */
    private function isSelected()
    {
        return !is_null($this->selected);
    }
}
