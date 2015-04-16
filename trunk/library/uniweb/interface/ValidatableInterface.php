<?php

interface ValidatableInterface
{
    /**
     * Megvizsgálja, hogy valid-e az objektum.
     * @return boolean
     */
    public function isValid();
}