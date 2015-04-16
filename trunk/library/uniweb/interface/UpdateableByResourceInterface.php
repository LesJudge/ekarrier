<?php
/**
 * Interface azokhoz az ActiveRecord modellekhez, amelyek valamilyen erőforrás által (ügyfél, munkáltató) 
 * módosíthatóak adatbázisban.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
interface UpdateableByResourceInterface extends \ResourcableInterface
{
    /**
     * Objektum létrehozása az UPDATE queryhez.
     * @param \ResourceInterface $ri Resource objektum.
     * @param array $attributes Attribútumok.
     * @return \UpdateableByResourceInterface
     */
    public static function createUpdateInstance(\ResourceInterface $ri, array $attributes = array());
}