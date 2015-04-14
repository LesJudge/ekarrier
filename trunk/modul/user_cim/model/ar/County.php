<?php
/**
 * @property int $cim_megye_id Megye azonosító.
 * @property int $cim_megye_nev Megye neve.
 */
class County extends \ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'cim_megye';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'cim_megye_id';
}