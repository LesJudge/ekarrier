<?php
namespace Uniweb\Library\Resource\Interfaces;
/**
 * Interface azokhoz a modellekhez, amelyek erőforrásként működhetnek. (pl. ügyfél, munkáltató)
 */
interface ResourceInterface
{
    /**
     * Visszatér az erőforrás azonosítójával.
     * @return mixed Erőforrás azonosító.
     */
    public function getResourceId();
}