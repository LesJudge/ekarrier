<?php

class DbInjectAbstract implements \DbInjectInterface
{
    /**
     * Adatbázis objektum.
     * @var \MYSQL_DB
     */
    protected $db;
    /**
     * Konstruktor.
     * @param \MYSQL_DB $db Adatbázis objektum.
     */
    public function __construct(\MYSQL_DB $db)
    {
        $this->setDb($db);
    }
    /**
     * Visszatér az adatbázis objektummal.
     * @return \MYSQL_DB
     */
    public function getDb()
    {
        return $this->db;
    }
    /**
     * Beállítja az adatbázis objektumot.
     * @param \MYSQL_DB $db Adatbázis objektum.
     */
    public function setDb(\MYSQL_DB $db)
    {
        $this->db = $db;
    }
}