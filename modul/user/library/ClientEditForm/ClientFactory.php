<?php

class ClientFactory
{
    const MODE_NEW = 'new';
    const MODE_EXISTING = 'existing';
    
    private function __construct()
    {
        // Disable constructor.
    }
    /**
     * Elkészíti a megfelelő ügyfél objektumot.
     * @param string $mode Új vagy létező ügyfél.
     * @return \ClientSave
     */
    public static function create($mode)
    {
        switch ($mode) {
            case self::MODE_NEW:
                return static::createNew();
            case self::MODE_EXISTING:
                $rm = new ReflectionMethod(get_called_class(), 'createExisting');
                return $rm->invokeArgs(null, array_slice(func_get_args(), 1));
            default:
                break;
        }
    }
    /**
     * Létrehozá egy új <b>ClientSave</b> objektumot.
     * @return \ClientSave
     */
    public static function createNew()
    {
        return new \ClientSave;
    }
    /**
     * A megadott paraméterek alapján készít egy <b>ClientSave</b> objektumot.
     * @param int $clientId Ügyfél azonosító.
     * @param boolean $relations Kérdezze le a kapcsolatokban szereplő adatokat is.
     * @return \ClientSave
     * @throws \ClientFactoryException
     */    
    public static function createExisting($clientId, $relations = false)
    {
        if ((int)$clientId > 0) {
            return \ClientSave::findClient($clientId, $relations);
        } else {
            throw new \ClientFactoryException('Az ügyfél azonosító nem megfelelő!');
        }
    }
}