<?php
namespace Uniweb\Library\DynamicFilter\Filter;
use Uniweb\Library\DynamicFilter\Interfaces\FilterInterface;
use PDO;


abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var PDO
     */
    protected $pdo;
    /**
     * Szűrő paraméterei.
     * @var array
     */
    protected $data;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * Visszatér a szűrő paramétereivel.
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * Visszatér a PDO objektummal.
     * @return array
     */
    public function getPdo()
    {
        return $this->pdo;
    }
    /**
     * Beállítja a szűrő paramétereit.
     * @param array $data Szűrő paraméterei.
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
    /**
     * Beállítja a PDO objektumot.
     * @param PDO $pdo PDO objektum.
     */
    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}