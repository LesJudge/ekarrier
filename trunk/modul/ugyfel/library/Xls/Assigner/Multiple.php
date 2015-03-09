<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Assigner;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\AssignerInterface;

class Multiple implements AssignerInterface
{
    public function assign(array $data, \PHPExcel_Worksheet $worksheet, $label, $key, &$col, &$row)
    {
        $startCol = $col;
        $max = 0;
        foreach ($data as $item) {
            $count = count($item);
            if ($count > $max) {
                $max = $count;
            }
        }
        for ($i = 0; $i < $max; $i++) {
            $worksheet->setCellValueByColumnAndRow($col, $row, $label);
            $row++;
            $worksheet->setCellValueByColumnAndRow($col, $row, $key . ($i + 1));
            $row++;
            $row = 1;
            $col++;
        }
        $col = $startCol;
        $row = 3;
        foreach ($data as $item) {
            for ($i = 0; $i < $max; $i++) {
                $value = '';
                if (isset($item[$i])) {
                    $value = $item[$i];
                }
                $worksheet->setCellValueByColumnAndRow($col, $row, $value);
                $col++;
            }
            $row++;
            $col = $startCol;
        }
        $col = $col + $max - 1;
    }
}