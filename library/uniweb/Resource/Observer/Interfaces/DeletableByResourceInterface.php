<?php
namespace Uniweb\Library\Resource\Observer\Intefaces;
use Uniweb\Library\Resource\Interfaces\ResourceInterface;
/**
 * Interface azokhoz a modellekhez, amelyek valamilyen erőforrás által (ügyfél, munkáltató) törölhetőek az adatbázisból.
 */
interface DeletableByResourceInterface
{
    /**
     * Törlés erőforrás alapján.
     * @param \Uniweb\Library\Resource\Interfaces\ResourceInterface $ri Erőforrás objektum.
     * @return \Uniweb\Library\Resource\Interfaces\ResourcableInterface Adatbázisból törölt elem modellje.
     */
    public static function deleteByResource(ResourceInterface $ri);
}