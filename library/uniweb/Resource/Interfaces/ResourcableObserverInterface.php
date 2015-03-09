<?php
namespace Uniweb\Library\Resource\Interfaces;
use SplObserver;

interface ResourcableObserverInterface extends SplObserver
{
    /**
     * Visszatér a modell objektummal.
     * @return object
     */
    public function getModel();
}