<?php

class ClientIOImport extends ClientIOImportAbstract implements ClientIOImportInterface
{
    protected $itemToLetter = array();
    
    public function import()
    {        
        $this->readHeader();
    }
    
    public function readHeader()
    {
        $worksheet = $this->phpExcel->getSheet();
        $hc = $worksheet->getHighestColumn();
        $hcIndex = PHPExcel_Cell::columnIndexFromString($hc);
        
        for ($i = 0; $i < $hcIndex; ++$i) {
            $cell = $worksheet->getCellByColumnAndRow($i, 2);
            //var_dump($cell->getValue());
            //var_dump($this->seemsMultiple($cell->getValue()));
            //var_dump($this->trimNo($cell->getValue()));
            //var_dump($cell->getColumn());
            
            $name = $cell->getValue();
            $trimmedName = null;
            $column = $cell->getColumn();
            if ($this->seemsMultiple($name)) {
                $trimmedName = $this->trimNo($name);
            }
            $this->itemToLetter[$column] = $this->lookUpItem($name, $trimmedName);
        }
        echo '<pre>', print_r($this->itemToLetter, true), '</pre>';
        exit;
    }
}