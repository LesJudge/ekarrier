<?php
/**
 * @property int $cim_orszag_id Megye azonosító.
 * @property int $cim_orszag_nev Megye neve.
 */
class Country extends \ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'cim_orszag';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'cim_orszag_id';
}