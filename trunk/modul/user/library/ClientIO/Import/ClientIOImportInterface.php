<?php

interface ClientIOImportInterface
{
    public function readHeader();
    
    public function import();
}