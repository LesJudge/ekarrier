<?php
namespace Uniweb\Library\Resource\Observer\Interfaces;

interface ValidatableInterface
{
    /**
     * Validálja a modelt.
     * @return boolean Validálás sikeressége.
     */
    public function validate();
}