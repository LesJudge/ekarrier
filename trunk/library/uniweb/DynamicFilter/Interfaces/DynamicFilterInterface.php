<?php
namespace Uniweb\Library\DynamicFilter\Interfaces;
use Uniweb\Library\DynamicFilter\Interfaces\PersistenceInterface;
use Uniweb\Library\DynamicFilter\Interfaces\FilterInterface;

interface DynamicFilterInterface
{
    /**
     * Szűrés végrehajtása.
     * @return array Szűrés eredménye.
     * @throws \Uniweb\Library\DynamicFilter\Interfaces\FilterInterface
     */
    public function filter();
    /**
     * Hozzáad egy új szűrő elemet.
     * @param string $alias Szűrő alias.
     * @param FilterInterface $filter Szűrő objektum.
     */
    public function addFilter($alias, FilterInterface $filter);
    /**
     * Törli a paraméterül adott szűrőt.
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
     * @return \Uniweb\Library\DynamicFilter\Interfaces\FilterInterface[] Dinamikus szűrőhöz tartozó szűrő elemek.
     */
    public function getFilters();
    /**
     * @return \Uniweb\Library\DynamicFilter\Interfaces\PersistenceInterface Perzisztencia objektum.
     */
    public function getPersistence();
    /**
     * @return string Visszatér a szűrő nevével.
     */
    public function getName();
    /**
     * Beállítja a perzisztencia objektumot.
     * @param PersistenceInterface $persistence Perzisztencia objektum.
     */
    public function setPersistence(PersistenceInterface $persistence);
}