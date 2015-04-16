<?php
/**
 * Erőforrás subject interface.
 */
interface ResourceSubjectInterface extends \SplSubject
{
    /**
     * Visszatér az erőforrással.
     * @return \ResourceInterface Erőforrás AR objektum.
     */
    public function getResource();
}