<?php
/**
 * Interface azokhoz az ActiveRecord modellekhez, amelyek valamilyen erőforrás által (ügyfél, munkáltató) új 
 * rekordként rögzíthetőek adatbázisban.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
interface InsertableByResourceInterface extends \ResourcableInterface
{
    /**
     * Objektum létrehozása az INSERT queryhez.
     * @param \ResourceInterface $ri Resource objektum.
     * @param array $attributes Attribútumok.
     * @return \InsertableByResourceInterface
     */
    public static function createInsertInstance(\ResourceInterface $ri, array $attributes = array());
}