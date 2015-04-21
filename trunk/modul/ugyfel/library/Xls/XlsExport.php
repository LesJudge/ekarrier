<?php
namespace Uniweb\Module\Ugyfel\Library\Xls;
use Uniweb\Module\Ugyfel\Library\Xls\XlsExportException;

class XlsExport
{
    /**
     * @var null|\PHPExcel
     */
    protected $phpExcel;
    /**
     * @var \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client[]
     */
    protected $clients = array();
    /**
     * Exportálandó attribútumok.
     * @var array
     */
    protected $exports = array();
    
    public function __construct(array $clients, array $exports)
    {
        $this->clients = $clients;
        $this->exports = $exports;
    }
    
    public function export()
    {
        $this->phpExcel = new \PHPExcel();
        $this->phpExcel->setActiveSheetIndex(0);
        $col = $row = 0; // Alapértelmezett oszlop és sor.
        $activeSheet = $this->phpExcel->getActiveSheet();
        foreach ($this->exports as $export) {
            if (class_exists($export['reader']) && class_exists($export['assigner'])) {
                /* @var $reader \Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface */
                $reader = new $export['reader'];
                $data = array();
                foreach ($this->clients as $client) {
                    $data[] = $reader->read($client);
                }
                /* @var $assigner \Uniweb\Module\Ugyfel\Library\Xls\Interfaces\AssignerInterface */
                $assigner = new $export['assigner'];
                $assigner->assign($data, $activeSheet, $export['label'], $export['key'], $col, $row);
                $row = 1;
                $col++;
            } else {
                throw new XlsExportException('Nem megfelelő reader vagy assigner!');
            }
        }
        $writer = new \PHPExcel_Writer_Excel2007($this->phpExcel);
        
        $filename = '/var/www/virtual/ekarrier.hu/teszt/htdocs/xls/' . time() . '.xls';
        $writer->save('/var/www/virtual/ekarrier.hu/teszt/htdocs/xls/' . time() . '.xls');
        
        echo readfile($filename);
        //return $writer->save('php://output');
        //return $writer->save('php://output');
    }
    /**
     * Visszatér a PHPExcel objektummal.
     * @return array
     */
    public function getPhpExcel()
    {
        return $this->phpExcel;
    }
    /**
     * Visszatér az exportálandó ügyfelekkel.
     * @return array
     */
    public function getClients()
    {
        return $this->clients;
    }
    /**
     * Visszatér az exportálandó attribútumokkal.
     * @return array
     */
    public function getExports()
    {
        return $this->exports;
    }
}