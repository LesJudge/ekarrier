<?php

interface AttachedUserUpdateInterface extends \AttachedUserInterface
{
    public function updateUser($username, $password, $email, $lastname, $firstname, $userId);
    
    public function updateAttached(array &$params, $userId, $id);
}