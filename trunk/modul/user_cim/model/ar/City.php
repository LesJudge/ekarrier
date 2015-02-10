<?php
/**
 * @property int $cim_varos_id Város azonosító.
 * @property int $cim_megye_id Megye azonosító.
 * @property string $cim_varos_nev Város neve.
 * @property \County $county Megye.
 */
class City extends \ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'cim_varos';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'cim_varos_id';
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        array(
            'county',
            'class_name' => 'County',
            'foreign_key' => 'cim_megye_id',
            'read_only' => true
        )
    );
}