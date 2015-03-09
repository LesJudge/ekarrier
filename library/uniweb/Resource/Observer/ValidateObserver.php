<?php
namespace Uniweb\Library\Resource\Observer;
use Uniweb\Library\Resource\Interfaces\ResourcableObserverInterface;
use Uniweb\Library\Resource\Observer\Interfaces\ValidatableInterface;
use SplSubject;

class ValidateObserver implements ResourcableObserverInterface
{
    /**
     * Model.
     * @var \Uniweb\Library\Resource\Observer\Intefaces\ValidatableInterface
     */
    protected $model;
    /**
     * 
     * @param \Uniweb\Library\Resource\Observer\Intefaces\ValidatableInterface $model Model.
     */
    public function __construct(ValidatableInterface $model)
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
        $subject->addResult($this->model->validate());
    }
    /**
     * Visszatér a modellel.
     * @return \Uniweb\Library\Resource\Observer\Intefaces\ValidatableInterface
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Beállítja a modelt.
     * @param \Uniweb\Library\Resource\Observer\Intefaces\ValidatableInterface $model Model.
     */
    public function setModel(ValidatableInterface $model)
    {
        $this->model = $model;
    }
}