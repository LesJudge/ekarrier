<?php
/**
 * @property int $munkakor_id Munkakör azonosító.
 * @property int $munkakor_attr_kategoria_id Munkakör kategória azonosító.
 */
class JobCategory extends \ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'munkakor_attr_kategoria';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'munkakor_attr_kategoria_id';
    /**
     * Kötelező attribútumokra vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'munkakor_id',
            'message' => 'A munkakör azonosító megadása kötelező!'
        ),
        array(
            'munkakor_attr_kategoria_id',
            'message' => 'A munkakör kategória azonosító megadása kötelező!'
        )
    );
    /**
     * Szám értékeket tároló attribútumokra vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_numericality_of = array(
        array(
            'munkakor_id',
            'greater_than' => 0,
            'message' => 'Nem megfelelő munkakör azonosító!'
        ),
        array(
            'munkakor_attr_kategoria_id',
            'greater_than' => 0,
            'message' => 'Nem megfelelő munkakör kategória azonosító!'
        )
    );
}