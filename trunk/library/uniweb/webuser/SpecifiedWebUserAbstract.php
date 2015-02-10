<?php

abstract class SpecifiedWebUserAbstract extends \DbInjectAbstract implements \SpecifiedWebUserInterface
{
    /**
     * Exception, amit akkor kell dobnia, ha a vizsgálat sikertelen.
     * @var string
     */
    protected $verifyException;
    /**
     * Konstruktor.
     * @param \MYSQL_DB $db Adatbázis objektum.
     * @param string $verifyException VerifyException.
     */
    public function __construct(\MYSQL_DB $db, $verifyException)
    {
        $this->setDb($db);
        $this->setVerifyException($verifyException);
    }
    
    public function findId($tableName, $idField, $userId)
    {
        $query = "SELECT " . $idField ." FROM " . $tableName . " WHERE user_id = " . (int)$userId . " LIMIT 1";
        return (int)$this->db->prepare($query)->query_select()->query_fetch_array($idField);
    }
    
    public function verifyByUserId($userId)
    {
        try {
            return (int)$this->findByUserId($userId);
        } catch (\Exception_MYSQL_Null_Rows $emnr) {
            return false;
        }
    }
    
    public function verify($userId)
    {
        return $this->verifyByUserIdAndThrow($userId, 'Exception_404');
    }
    /**
     * 
     * @param int $userId Felhasználó azonosító.
     * @param string $verifyException Exception neve.
     * @return int
     * @throws \Exception
     */
    public function verifyByUserIdAndThrow($userId, $verifyException = null)
    {
        $id = $this->verifyByUserId($userId);
        if (!$id) {
            if ($verifyException === null) {
                $exception = $this->verifyException;
            } elseif ($this->validateVerifyException($verifyException)) {
                $exception = $verifyException;
            } else {
                throw new \InvalidArgumentException('Nem megfelelő verifyException!');
            }
            throw new $exception;
        }
        return $id;
    }
    /**
     * 
     * @param int $userId Felhasználó azonosító.
     * @param string $url RequestURI.
     * @param \Closure $setHeader
     * @return int
     */
    public function verifyByUserIdAndRedirect($userId, $url, \Closure $setHeader = null)
    {
        $id = $this->verifyByUserId($userId);
        if (!$id) {
            if (!is_null($setHeader)) {
                call_user_func($setHeader, $this);
            }
            header('Location: ' . Rimo::getConfig()->DOMAIN . $url);
            exit;
        }
        return $id;
    }
    /**
     * Visszatér a verifyException nevével.
     * @return string
     */
    public function getVerifyException()
    {
        return $this->verifyException;
    }
    /**
     * Beállítja a verifyException-t, ha az megfelelő.
     * @param string $verifyException Exception neve.
     * @throws \InvalidArgumentException
     */
    public function setVerifyException($verifyException)
    {
        if ($this->validateVerifyException($verifyException)) {
            $this->verifyException = $verifyException;
        } else {
            throw new \InvalidArgumentException('Nem megfelelő verifyException!');
        }
    }
    /**
     * Megvizsgálja, hogy a verifyException megfelelő-e.
     * @param string $verifyException Exception neve.
     * @return boolean
     */
    protected function validateVerifyException($verifyException)
    {
        if (is_string($verifyException) && class_exists($verifyException)) {
            $rc = new \ReflectionClass($verifyException);
            return $rc->isSubclassOf('Exception');
        }
        return false;
    }
}