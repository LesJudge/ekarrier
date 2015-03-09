<?php
namespace Uniweb\Library\Resource\Observer;
use Uniweb\Library\Resource\Interfaces\ResourcableObserverInterface;
use Uniweb\Library\Resource\Observer\Interfaces\SavableInterface;
use SplSubject;

class SaveObserver implements ResourcableObserverInterface
{
    /**
     * Model.
     * @var \Uniweb\Library\Resource\Observer\Intefaces\SavableInterface
     */
    protected $model;
    /**
     * 
     * @param \Uniweb\Library\Resource\Observer\Intefaces\SavableInterface $model Model.
     */
    public function __construct(SavableInterface $model)
    {
        $this->model = $model;
    }
    /**
     * Observer Update.
     * @param SplSubject $subject
     */
    public function update(SplSubject $subject)
    {
        /* @var $subject \Uniweb\Library\Resource\Interfaces\StatefulResourceSubjectInterface */
        $this->model->setResourceId($subject->getResource()->getResourceId());
        $subject->addResult($this->model->save());
    }
    /**
     * Visszatér a modellel.
     * @return \Uniweb\Library\Resource\Observer\Intefaces\SavableInterface
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Beállítja a modelt.
     * @param \Uniweb\Library\Resource\Observer\Intefaces\SavableInterface $model Model.
     */
    public function setModel(SavableInterface $model)
    {
        $this->model = $model;
    }
}