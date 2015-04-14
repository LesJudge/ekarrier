<?php
/**
 * @property int $cim_iranyitoszam_id Irányítószám azonosító.
 * @property int $cim_varos_id Város azonosító.
 * @property string $cim_iranyitoszam_iranyitoszam Irányítószám.
 * @property \City $city Város.
 */
class ZipCode extends \ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'cim_iranyitoszam';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'cim_iranyitoszam_id';
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        array(
            'city',
            'class_name' => 'City',
            'foreign_key' => 'cim_varos_id',
            'read_only' => true
        )
    );
    /**
     * Irányítószám alapú keresés.
     * @param mixed $zipCode Irányítószám
     * @return self
     */
    public static function findByZipCode($zipCode)
    {
        return self::find('first', array(
            'conditions' => array(
                'cim_iranyitoszam_iranyitoszam' => (string)$zipCode
            ),
            // Eager loading.
            'include' => array('city' => array(
                'county'
            ))
        ));
    }
}