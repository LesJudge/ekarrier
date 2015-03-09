<?php
namespace Uniweb\Module\Cim\Library\Repository;
use Uniweb\Module\Cim\Library\AddressRepositoryInterface;
use Uniweb\Module\Cim\Library\AddressFinderInteface;
/**
 * @property \Uniweb\Module\Cim\Library\AddressFinderInteface $finder Finder objektum.
 * @property array $fields Kiválasztott mezők.
 */
abstract class AbstractAddressRepository implements AddressRepositoryInterface
{
    /**
     * @var AddressFinderInteface
     */
    protected $finder;
    
    protected $fields;
    
    public function __construct(AddressFinderInteface $finder, array $fields = array())
    {
        $this->finder = $finder;
        if (!empty($fields)) {
            $this->fields = $fields;
        }
    }
    /**
     * 
     * @return AddressFinderInteface
     */
    public function getFinder()
    {
        return $this->finder;
    }
    /**
     * 
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
}