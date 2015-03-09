<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Interfaces;

interface AssignerInterface
{
    public function assign(array $data, \PHPExcel_Worksheet $worksheet, $label, $key, &$col, &$row);
}