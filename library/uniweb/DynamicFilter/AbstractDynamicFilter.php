<?php
namespace Uniweb\Library\DynamicFilter;

use Uniweb\Library\DynamicFilter\Exceptions\DynamicFilterException;
use Uniweb\Library\DynamicFilter\Interfaces\DynamicFilterInterface;
use Uniweb\Library\DynamicFilter\Interfaces\FilterInterface;
use Uniweb\Library\DynamicFilter\Interfaces\PersistenceInterface;

abstract class AbstractDynamicFilter implements DynamicFilterInterface
{
    /**
     * Szűrő neve.
     * @var string
     */
    protected $name;
    
    /**
     * Szűrő példányok.
     * @var FilterInterface
     */
    protected $filters = array();
    
    /**
     * Perzisztencia objektum.
     * @var PersistenceInterface
     */
    protected $persistence;
    
    public function __construct(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addFilter($alias, FilterInterface $filter)
    {
        if (!isset($this->filters[$alias])) {
            $this->filters[$alias] = $filter;
        } else {
            throw new DynamicFilterException('A/az (' . $alias . ') szűrő már használatban van!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getPersistence()
    {
        return $this->persistence;
    }

    /**
     * {@inheritdoc}
     */
    public function removeFilter($alias)
    {
        if (isset($this->filters[$alias])) {
            unset($this->filters[$alias]);
        } else {
            throw new DynamicFilterException('A/az (' . $alias . ') szűrő nem lett a szűréshez csatolva!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setPersistence(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $this->persistence->create($this);
    }
    
    /**
     * {@inheritdoc}
     */
    public function read()
    {
        return $this->persistence->read($this);
    }
    
    /**
     * {@inheritdoc}
     */
    public function destroy()
    {
        $this->persistence->destroy($this);
    }
}