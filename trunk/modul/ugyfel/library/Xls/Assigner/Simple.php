<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Assigner;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\AssignerInterface;

class Simple implements AssignerInterface
{
    public function assign(array $data, \PHPExcel_Worksheet $worksheet, $label, $key, &$col, &$row)
    {
        $worksheet->setCellValueByColumnAndRow($col, $row, $label);
        $row++;
        $worksheet->setCellValueByColumnAndRow($col, $row, $key);
        $row++;
        foreach ($data as $item) {
            $worksheet->setCellValueByColumnAndRow($col, $row, $item);
            $row++;
        }
    }
}