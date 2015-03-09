<?php
namespace Uniweb\Library\Resource\Observer\Observers;
use Uniweb\Library\Resource\Interfaces\ResourcableObserverInterface;
use Uniweb\Library\Resource\Interfaces\DeletableByResourceInterface;
use SplSubject;

class DeleteByResourceObserver implements ResourcableObserverInterface
{
    /**
     * A modell, amivel dolgozik az observer.
     * @var DeletableByResourceInterface
     */
    protected $model;
    /**
     * Létrehoz egy DeleteByResource observert.
     * @param DeletableByResourceInterface $model Model.
     */
    public function __construct(DeletableByResourceInterface $model)
    {
        $this->model = $model;
    }
    /**
     * Observer update.
     * @param \ResourceSubjectInterface $subject Subject.
     */
    public function update(SplSubject $subject)
    {
        /* @var $subject \ResourceSubjectInterface */
        $this->model->deleteByResource($subject->getResource());
    }
    /**
     * Visszatér a modellel.
     * @return DeletableByResourceInterface
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Beállítja a modellt.
     * @param DeletableByResourceInterface $model Model.
     */
    public function setModel(DeletableByResourceInterface $model)
    {
        $this->model = $model;
    }
}