<?php
namespace Uniweb\Library\DynamicFilter\Interfaces;
use PDO;

interface FilterInterface
{
    /**
     * Szűrés.
     * @return array
     * @throws \Uniweb\Library\DynamicFilter\Exceptions\FilterException
     */
    public function filter();
    /**
     * Visszatér a PDO objektummal.
     * @return PDO PDO objektum.
     */
    public function getPdo();
    /**
     * Visszatér a szűrő paramétereivel.
     * @return array Szűrő paraméterei.
     */
    public function getData();
    /**
     * Beállítja a PDO objektumot.
     * @param PDO $pdo PDO objektum.
     */
    public function setPdo(PDO $pdo);
    /**
     * Beállítja a szűrő paramétereit.
     * @param array $data
     */
    public function setData(array $data);
}