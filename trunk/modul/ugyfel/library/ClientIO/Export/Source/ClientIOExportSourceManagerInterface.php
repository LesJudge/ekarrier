<?php

interface ClientIOExportSourceManagerInterface
{
    public function addSource($name, $clientId, $source);
    
    public function isSourceExists($source);
    
    public function getSource($source, $validate = true);
    
    public function getSourceLength($source);
    
    public function getSources();
}