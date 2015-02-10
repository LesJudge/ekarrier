<?php

class ClientIOExportSource implements ClientIOExportSourceInterface, Countable
{
    /**
     * Adathalmaz neve.
     * @var string
     */
    protected $name;
    /**
     * Adathalmaz.
     * @var mixed
     */
    protected $data;
    /**
     * Konstruktor.
     * @param string $name Forrás neve.
     * @param mixed $data Forrás.
     */
    public function __construct($name, $data)
    {
        $this->name = $name;
        $this->data = $data;
    }
    /**
     * Visszatér az adathalmaz nevével.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Visszatér az adathalmazzal.
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * Megszámolja az adathalmaz elemeit.
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }
}