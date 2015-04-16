<?php
/**
 * Állapotmegőrző resource subject interface.
 */
interface StatefulResourceSubjectInterface extends \ResourceSubjectInterface
{
    /**
     * Visszatér a művelet eredményével.
     * @return boolean Sikeres volt-e a művelet.
     */
    public function isOk();
    /**
     * Módosítja a művelet eredményét a paraméterül adott értékkel.
     * @param boolean $result
     */
    public function addResult($result);
}