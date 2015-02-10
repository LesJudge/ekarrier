<?php

interface AttachableUserModelInterface
{
    /**
     * Visszatér a felhasználó azonosítóval.
     * @return int
     */
    public function getUserId();
    
    public function findUser($userId);
    
    public function getAttachedId();
    
    public function setAttachedId($id);
    
    public function setAttacher(\AttachedUserInsertInterface $attacher);
    
    public function setAttached(\AttachedUserUpdateInterface $attached);
    
    public function setFinder(\AttachedUserFinderInterface $finder);
}