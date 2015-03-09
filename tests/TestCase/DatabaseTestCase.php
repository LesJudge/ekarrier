<?php
namespace Tests\Uniweb\TestCase;
use PHPUnit_Extensions_Database_TestCase;
use PDO;

abstract class DatabaseTestCase extends PHPUnit_Extensions_Database_TestCase
{
    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                $dsn = sprintf(
                    $GLOBALS['testDbDsn'], 
                    $GLOBALS['testDbDatabaseName'], 
                    $GLOBALS['testDbCharset'], 
                    $GLOBALS['testDbHost']
                );
                self::$pdo = new PDO($dsn, $GLOBALS['testDbUsername'], $GLOBALS['testDbPassword']);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['testDbDatabaseName']);
        }
        return $this->conn;
    }
}