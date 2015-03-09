<?php
namespace Uniweb\Module\Nyelvtudas\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\Behaviorable;
/**
 * @property int $nyelvtudas_nyelv_id Nyelv azonosító.
 * @property string $nev Nyelv.
 * @property int $letrehozo_id Nyelv létrehozó azonosító.
 * @property int $modosito_id Nyelv módosító azonosító.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Nyelv létrehozásának ideje.
 * @property ActiveRecord\DateTime $modositas_timestamp Nyelv módosításának ideje.
 * @property int $modositas_szama Nyelv módosításának száma.
 * @property int $nyelvtudas_nyelv_aktiv Aktív-e a nyelv.
 * @property int $nyelvtudas_nyelv_torolt Törölt-e a nyelv.
 * 
 */
class Language extends Behaviorable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'nyelvtudas_nyelv';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'nyelvtudas_nyelv_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array('nyelvtudas_nyelv_id');
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array(
            'nev',
            'message' => 'Kötelező mező!'
        )
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array(
        array(
            'nev',
            'within' => array(3, 128),
            'too_short' => 'Legalább 3 karakter hosszúnak kell lennie!',
            'too_long' => 'Legfeljebb 128 karakter hosszú lehet!'
        )
    );
}