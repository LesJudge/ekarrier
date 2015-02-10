<?php

interface SpecifiedWebUserInterface
{
    public function findByUserId($userId);
    
    public function verifyByUserId($userId);
    
    public function verifyByUserIdAndThrow($userId, $verifyException = null);
    
    public function verifyByUserIdAndRedirect($userId, $url, \Closure $setHeader = null);
    
    public function verify($userId);
}