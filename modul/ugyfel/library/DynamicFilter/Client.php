<?php
namespace Uniweb\Module\Ugyfel\Library\DynamicFilter;
use Uniweb\Module\Ugyfel\Library\Repository\ClientRepository;
use Uniweb\Library\DynamicFilter\AbstractDynamicFilter;

class Client extends AbstractDynamicFilter
{
    protected $name = 'clientsFilter';
    
    public function filter()
    {
        $ids = array();
        $filteredIds = array();
        $countFilters = count($this->filters);
        foreach ($this->filters as $filter) {
            $result = $filter->filter();
            if (!empty($result)) {
                foreach ($result as $id) {
                    if (!isset($filteredIds[$id])) {
                        $filteredIds[$id] = 1;
                    } else {
                        $filteredIds[$id]++;
                    }
                }
            } else {
                $filteredIds = array();
                break;
            }
        }
        foreach ($filteredIds as $id => $count) {
            if ($count === $countFilters) {
                $ids[] = $id;
            }
        }
        $clientRepository = new ClientRepository;
        $clients = array();
        foreach ($ids as $clientId) {
            try {
                $clients[] = $clientRepository->findById($clientId);
            } catch (\ActiveRecord\RecordNotFound $rnf) {
                
            }
        }
        return $clients;
    }
}