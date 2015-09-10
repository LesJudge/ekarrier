<?php
namespace Uniweb\Library\DynamicFilter\Interfaces;

use Uniweb\Library\DynamicFilter\Exceptions\FilterException;
use Uniweb\Library\DynamicFilter\Interfaces\FilterInterface;
use Uniweb\Library\DynamicFilter\Interfaces\PersistenceInterface;

interface DynamicFilterInterface
{
    /**
     * Szűrés végrehajtása.
     * 
     * @return array Szűrés eredménye.
     * @throws FilterException
     */
    public function filter();
    
    /**
     * Hozzáad egy új szűrő elemet.
     * 
     * @param string $alias Szűrő alias.
     * @param FilterInterface $filter Szűrő objektum.
     */
    public function addFilter($alias, FilterInterface $filter);
    
    /**
     * Törli a paraméterül adott szűrőt.
     * 
     * @param string $alias Szűrő alias.
     */
    public function removeFilter($alias);
    
    /**
     * Dinamikus szűrő létrehozása.
     */
    public function create();
    
    /**
     * Dinamikus szűrő törlése.
     */
    public function destroy();
    
    /**
     * Szűrési paraméterek kiolvasása.
     */
    public function read();
    
    /**
     * Visszatér a szűrőhöz tartozó elemekkel.
     * 
     * @return FilterInterface[] Dinamikus szűrőhöz tartozó szűrő elemek.
     */
    public function getFilters();
    
    /**
     * Visszatér a perzisztencia objektummal.
     * 
     * @return PersistenceInterface Perzisztencia objektum.
     */
    public function getPersistence();
    
    /**
     * Visszatér a szűrő nevével.
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Beállítja a perzisztencia objektumot.
     * 
     * @param PersistenceInterface $persistence Perzisztencia objektum.
     */
    public function setPersistence(PersistenceInterface $persistence);
}