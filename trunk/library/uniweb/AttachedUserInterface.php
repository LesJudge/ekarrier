<?php

interface AttachedUserInterface
{
    public function getModelEditHelper();
    
    public function save(array &$params, $userId, $id);
    
    public function overrideParams(&$params);
}