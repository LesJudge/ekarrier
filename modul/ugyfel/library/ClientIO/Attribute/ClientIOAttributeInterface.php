<?php

interface ClientIOAttributeInterface
{
    public function getName();
    
    public function getLabel();
    
    public function getGetter();
    
    public function getSetter();
    
    public function setName($name);
    
    public function setLabel($label);
    
    public function setGetter($getter);
    
    public function setSetter($setter);
    
    public function isMultiple();
}