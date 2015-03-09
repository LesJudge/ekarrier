<?php
namespace Uniweb\Library\DynamicFilter;
use Uniweb\Library\DynamicFilter\Interfaces\DynamicFilterInterface;
use Uniweb\Library\DynamicFilter\Interfaces\PersistenceInterface;
use Uniweb\Library\DynamicFilter\Exceptions\DynamicFilterException;

abstract class AbstractDynamicFilter implements DynamicFilterInterface
{
    /**
     * Szűrő neve.
     * @var string
     */
    protected $name;
    /**
     * Szűrő példányok.
     * @var \Uniweb\Library\DynamicFilter\Interfaces\FilterInterface
     */
    protected $filters = array();
    /**
     * Perzisztencia objektum.
     * @var \Uniweb\Library\DynamicFilter\Interfaces\PersistenceInterface
     */
    protected $persistence;
    
    public function __construct(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
    }
    
    public function addFilter($alias, Interfaces\FilterInterface $filter)
    {
        if (!isset($this->filters[$alias])) {
            $this->filters[$alias] = $filter;
        } else {
            throw new DynamicFilterException('A/az (' . $alias . ') szűrő már használatban van!');
        }
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPersistence()
    {
        return $this->persistence;
    }

    public function removeFilter($alias)
    {
        if (isset($this->filters[$alias])) {
            unset($this->filters[$alias]);
        } else {
            throw new DynamicFilterException('A/az (' . $alias . ') szűrő nem lett a szűréshez csatolva!');
        }
    }

    public function setPersistence(Interfaces\PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
    }
    
    public function create()
    {
        $this->persistence->create($this);
    }
    
    public function read()
    {
        return $this->persistence->read($this);
    }
    
    public function destroy()
    {
        $this->persistence->destroy($this);
    }
}