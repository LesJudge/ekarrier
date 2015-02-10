<?php
interface ValidateRequest
{
    public function isValidRequest();
    
    public function invalidRequest();
}