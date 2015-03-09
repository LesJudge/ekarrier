<?php
namespace Uniweb\Library\DynamicFilter;
use Uniweb\Library\DynamicFilter\Factory;
use Uniweb\Library\DynamicFilter\Interfaces\DynamicFilterInterface;
use Uniweb\Library\DynamicFilter\Exceptions\DynamicFilterException;

class FilterSetup
{
    /**
     * @var \Uniweb\Library\DynamicFilter\Interfaces\FactoryInterface
     */
    protected $factory;
    /**
     * @var \Uniweb\Library\DynamicFilter\Interfaces\DynamicFilterInterface
     */
    protected $filter;
    /**
     * @var array
     */
    protected $from;
    
    public function __construct(DynamicFilterInterface $filter, Factory $factory, array $from)
    {
        $this->filter = $filter;
        $this->factory = $factory;
        $this->from = $from;
    }
    
    public function setUp(array $filters)
    {
        foreach ($filters as $alias => $data) {
            /*
            if (isset($this->from[$alias])) {
                $filter = $this->from[$alias];
                $filter->setData($data);
                $this->filter->addFilter($alias, $filter);
            } else {
                throw new DynamicFilterException('A/az ' . $alias . ' szűrő nem létezik!');
            }
            */
            if (isset($this->from[$alias])) {
                /* @var $filter \Uniweb\Library\DynamicFilter\Interfaces\FilterInterface */
                $filter = call_user_func_array(array($this->factory, 'factory'), $this->from[$alias]);
                $filter->setData($data);
                $this->filter->addFilter($alias, $filter);
            } else {
                throw new DynamicFilterException('A/az ' . $alias . ' szűrő nem létezik!');
            }
        }
    }
    
    public function getFactory()
    {
        return $this->factory;
    }
    
    public function getFilter()
    {
        return $this->filter;
    }
    /**
     * 
     * @return array
     */
    public function getFrom()
    {
        return $this->from;
    }
    
    public function setFactory(Factory $factory)
    {
        $this->factory = $factory;
    }
    
    public function setFilter(DynamicFilterInterface $filter)
    {
        $this->filter = $filter;
    }
    /**
     * 
     * @param array
     */
    public function setFrom(array $from)
    {
        $this->from = $from;
    }
}