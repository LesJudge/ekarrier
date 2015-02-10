<?php

interface ClientIOInterface
{   
    public function getDefaultGetter();
    
    public function getDefaultSetter();
    
    public function setDefaultGetter($getter);
    
    public function setDefaultSetter($setter);
    
    public function setAttributes(array $attributes);
    
    public function setUpIoAttributes(array $attributes);
    
    public function setUpIoAttribute($key, array $data);
}