<?php
interface ClientIOExportElementInterface
{
    public function getIOAttribute($attribute, $soure = null);
    
    public function setIOAttribute($attribute, $value);
    
    public function getClient();
}