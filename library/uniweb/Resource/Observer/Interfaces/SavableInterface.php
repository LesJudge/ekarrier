<?php
namespace Uniweb\Library\Resource\Observer\Interfaces;

interface SavableInterface
{
    /**
     * Menti a modelt.
     * @return boolean Mentés eredménye.
     */
    public function save();
    /**
     * Beállítja az erőforrás azonosítót.
     * @param int $resourceId Erőforrás azonosító.
     */
    public function setResourceId($resourceId);
}