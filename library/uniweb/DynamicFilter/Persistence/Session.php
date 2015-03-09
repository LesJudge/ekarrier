<?php
namespace Uniweb\Library\DynamicFilter\Persistence;
use Uniweb\Library\DynamicFilter\Persistence\AbstractPersistence;
use Uniweb\Library\DynamicFilter\Exceptions\PersistenceException;

class Session extends AbstractPersistence
{
    public function create(\Uniweb\Library\DynamicFilter\Interfaces\DynamicFilterInterface $dynamicFilter)
    {
        $filterSession = array();
        foreach ($dynamicFilter->getFilters() as $alias => $filter) {
            $filterSession[$alias] = $filter->getData();
        }
        $this->session[$dynamicFilter->getName()] = $filterSession;
    }

    public function destroy(\Uniweb\Library\DynamicFilter\Interfaces\DynamicFilterInterface $dynamicFilter)
    {
        if (isset($this->session[$dynamicFilter->getName()])) {
            unset($this->session[$dynamicFilter->getName()]);
        } else {
            throw new PersistenceException('Nincs használatban lévő szűrő!');
        }
    }
    
    public function read(\Uniweb\Library\DynamicFilter\Interfaces\DynamicFilterInterface $dynamicFilter)
    {
        if (isset($this->session[$dynamicFilter->getName()])) {
            return $this->session[$dynamicFilter->getName()];
        }
        return null;
    }
}