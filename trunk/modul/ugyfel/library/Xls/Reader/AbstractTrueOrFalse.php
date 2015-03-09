<?php
namespace Uniweb\Module\Ugyfel\Library\Xls\Reader;
use Uniweb\Module\Ugyfel\Library\Xls\Interfaces\ReaderInterface;

abstract class AbstractTrueOrFalse implements ReaderInterface
{
    protected function createReadableValue($value)
    {
        switch ($value) {
            case 0:
                return 'nem';
                break;
            case 1:
                return 'igen';
                break;
            default:
                return '';
                break;
        }
    }
}