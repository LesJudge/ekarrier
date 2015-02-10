<?php

class ModelEditHelper
{
    /**
     * Megvizsgálja, hogy a paraméterül adott érték nagyobb-e, mint 0. Ha igen, visszatér vele, ha nem, akkor pedig 
     * null a visszatérési érték.
     * @param mixed $intValue Érték.
     * @return mixed
     */
    public function idMayNull($intValue)
    {
        $intValue = (int)$intValue;
        return $intValue > 0 ? $intValue : 'NULL';
    }
    
    public function stringMayNull($string)
    {
        return is_string($string) ? "'" . mysql_real_escape_string($string) . "'" : "NULL";
    }
}