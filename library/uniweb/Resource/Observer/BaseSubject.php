<?php
namespace Uniweb\Library\Resource\Observer;
use Uniweb\Library\Resource\Interfaces\ResourceSubjectInterface;
use Uniweb\Library\Resource\Interfaces\ResourceInterface;
use Uniweb\Library\Observer\Subject;

class BaseSubject extends Subject implements ResourceSubjectInterface
{
    /**
     * Erőforrás.
     * @var \ResourceInterface
     */
    protected $resource;
    /**
     * Konstruktor.
     * @param \Uniweb\Library\Resource\Interfaces\ResourceInterface $resource Erőforrás objektum.
     */
    public function __construct(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }
    /**
     * Visszatér az erőforrással.
     * @return \Uniweb\Library\Resource\Interfaces\ResourceInterface
     */
    public function getResource()
    {
        return $this->resource;
    }
    /**
     * Beállítja az erőforrás objektumot.
     * @param \Uniweb\Library\Resource\Interfaces\ResourceInterface $resource "Erőforrás" objektum.
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }
}