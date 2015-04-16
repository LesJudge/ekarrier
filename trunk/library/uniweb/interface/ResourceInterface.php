<?php
/**
 * Interface azokhoz az ActiveRecord modellekhez, amelyek erőforrásként működhetnek. (pl. ügyfél, munkáltató)
 */
interface ResourceInterface
{
    /**
     * Visszatér az erőforrás azonosítójával.
     * @return mixed Erőforrás azonosító.
     */
    public function getResourceId();
}