<?php

interface AttachedUserInsertInterface extends \AttachedUserInterface
{
    public function rightGroupId();
    
    public function insertUser($username, $password, $email, $lastname, $firstname);
    
    public function insertRightGroup($userId, $rightGroupId);
    
    public function attachTo($userId, $toId);
    
    public function insertAttachable(array &$params, $userId, $id);
}