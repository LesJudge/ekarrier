<?php

interface SavableInterface
{
    /**
     * Menti az objektumot.
     * @param boolean $validate Validáljon-e mentés előtt.
     * @return boolean
     */
    public function save($validate);
}