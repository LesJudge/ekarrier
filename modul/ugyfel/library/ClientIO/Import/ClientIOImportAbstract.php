<?php

abstract class ClientIOImportAbstract extends ClientIO implements ClientIOImportInterface
{
    protected function seemsMultiple($name)
    {
        return (boolean)preg_match('/[0-9]+$/', $name);
    }
    
    protected function trimNo($name)
    {
        return preg_replace('/[0-9]+$/', '', $name);
    }
    
    protected function lookUpItem($name, $trimmedName)
    {
        $single = $multiple = false;
        /* @var $ioAttribute ClientIOAttributeInterface */
        foreach ($this->ioAttributes as $ioAttribute) {
            $ioName = $ioAttribute->getName();
            $ioMultiple = $ioAttribute->isMultiple();
            if ($ioName === $name && !$ioMultiple) {
                $single = $ioAttribute;
            }
            if ($ioName === $trimmedName && $ioMultiple) {
                $multiple = $ioAttribute;
            }
        }
        if ($single || $multiple) {
            return is_object($single) ? $single : $multiple;
        }
        throw new \ClientIOImportException(
            'A/az ' . (string)$name . ' / ' . (string)$trimmedName . ' attribútum ismeretlen!'
        );
    }
}