<?php
namespace Uniweb\Library\Resource\Interfaces;
use SplSubject;
/**
 * Erőforrás subject interface.
 */
interface ResourceSubjectInterface extends SplSubject
{
    /**
     * Visszatér az erőforrással.
     * @return \Uniweb\Library\Resource\Interfaces\ResourceInterface Erőforrás objektum.
     */
    public function getResource();
}