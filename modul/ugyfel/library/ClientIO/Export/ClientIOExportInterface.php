<?php

interface ClientIOExportInterface
{
    public function validateClient($client);
    
    public function writeHeader();
    
    public function writeHeaderItem($attribute, &$col, &$row);
    
    public function writeClients();
    
    public function writeClient($attribute, $client, &$col, &$row);
    
    public function export();
}