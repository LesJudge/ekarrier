<?php
namespace Uniweb\Library\DynamicFilter\Filter;
use Uniweb\Library\DynamicFilter\Filter\AbstractFilter;

abstract class FieldFilter extends AbstractFilter
{
    /**
     * Mező neve, amit kiválaszt.
     * @var string
     */
    protected $select;
    /**
     * Mező neve, amit vizsgál.
     * @var string
     */
    protected $field;
    /**
     * Tábla neve, amiben a lekérdezés történik.
     * @var string
     */
    protected $table;
    /**
     * Visszatér a kiválaszott mező nevével.
     * @return string
     */
    public function getSelect()
    {
        return $this->select;
    }
    /**
     * Visszatér a vizsgált mező nevével.
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
    /**
     * Visszatér a tábla nevével.
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }
    /**
     * Beállítja a kiválasztott mezőt.
     * @param string $select Kiválasztott mező neve.
     * @return self
     */
    public function setSelect($select)
    {
        $this->select = $select;
        return $this;
    }
    /**
     * Beállítja a vizsgált mezőt.
     * @param string $field Vizsgált mező neve.
     * @return self
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
    /**
     * Beállítja a tábla nevét.
     * @param string $table Tábla neve.
     * @return self
     */
    public function setTable($table)
    {
        $this->table = $table;
    }
}