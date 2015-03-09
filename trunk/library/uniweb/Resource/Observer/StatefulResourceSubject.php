<?php
namespace Uniweb\Library\Resource\Observer;
use Uniweb\Library\Resource\Interfaces\StatefulResourceSubjectInterface;
use Uniweb\Library\Resource\Observer\BaseSubject;

class StatefulResourceSubject extends BaseSubject implements StatefulResourceSubjectInterface
{
    /**
     * Sikeres volt-e a művelet.
     * @var boolean
     */
    protected $isOk = true;
    /**
     * Visszatér a művelet eredményével.
     * @return boolean
     */
    public function isOk()
    {
        return (boolean)$this->isOk;
    }
    /**
     * Módosítja a művelet eredményét a paraméterül adott értékkel.
     * @param boolean $result Eredmény.
     */
    public function addResult($result)
    {
        $this->isOk &= (boolean)$result;
    }
}