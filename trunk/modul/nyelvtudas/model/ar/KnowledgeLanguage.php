<?php
/**
 * Nyelvtudás nyelv ActiveRecord model.
 * 
 * @property int $nyelvtudas_nyelv_id Nyelv azonosító.
 * @property string $nyelvtudas_nyelv_nev Nyelv.
 * @property int $nyelvtudas_nyelv_letrehozo Nyelv létrehozó azonosító.
 * @property int $nyelvtudas_nyelv_modosito Nyelv módosító azonosító.
 * @property ActiveRecord\DateTime $nyelvtudas_nyelv_letrehozas_datum Nyelv létrehozásának ideje.
 * @property ActiveRecord\DateTime $nyelvtudas_nyelv_modositas_datum Nyelv módosításának ideje.
 * @property int $nyelvtudas_nyelv_modositas_szama Nyelv módosításának száma.
 * @property int $nyelvtudas_nyelv_aktiv Aktív-e a nyelv.
 * @property int $nyelvtudas_nyelv_torolt Törölt-e a nyelv.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class KnowledgeLanguage extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    static $table_name = 'nyelvtudas_nyelv';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    static $primary_key = 'nyelvtudas_nyelv_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    static $attr_protected = array(
        'nyelvtudas_nyelv_letrehozo',
        'nyelvtudas_nyelv_modosito',
        'nyelvtudas_nyelv_letrehozas_datum',
        'nyelvtudas_nyelv_modositas_datum',
        'nyelvtudas_nyelv_modositas_szama'
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    static $validates_presence_of = array(
        array(
            'nyelvtudas_nyelv_nev',
            'message' => 'Kötelező mező!'
        )
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    static $validates_length_of;
    /**
     * Név minimális hossza.
     * @var int
     */
    protected $nameMin = 3;
    /**
     * Név maximális hossza.
     * @var int
     */
    protected $nameMax = 32;
    /**
     * Létrehozás idejét tároló mező neve.
     * @var mixed
     */
    protected $createdAttribte = 'nyelvtudas_nyelv_letrehozas_datum';
    /**
     * Módosítás idejét tároló mező neve.
     * @var mixed
     */
    protected $modifiedAttribute = 'nyelvtudas_nyelv_modositas_datum';
    /**
     * Létrehozó felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $creatorAttribute = 'nyelvtudas_nyelv_letrehozo';
    /**
     * Módosító felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $modificatoryAttribute = 'nyelvtudas_nyelv_modosito';
    /**
     * Módosítások számát tároló mező neve.
     * @var mixed
     */
    protected $nomAttribute = 'nyelvtudas_nyelv_modositas_szama';
    /**
     * Konstruktor.
     * @param array $attributes
     * @param boolean $guard_attributes
     * @param boolean $instantiating_via_find
     * @param boolean $new_record
     */
    public function __construct(
        array $attributes = array(), 
        $guard_attributes = true, 
        $instantiating_via_find = false, 
        $new_record = true
    ) {
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
        self::$validates_length_of = array(
            array(
                'nyelvtudas_nyelv_nev',
                'within' => array($this->getNameMin(), $this->getNameMax()),
                'too_short' => 'Legalább ' . $this->getNameMin() . ' karakter hosszúnak kell lennie!',
                'too_long' => 'Legfeljebb ' . $this->getNameMax() . ' karakter hosszú lehet!'
            )
        );
    }
    /**
     * Aktív, nem törölt szűrő.
     * @return array
     */
    public static function scopeActiveNotDeleted()
    {
        return array(
            'conditions' => array(
                'nyelvtudas_nyelv_aktiv = 1 AND nyelvtudas_nyelv_torolt = 0'
            )
        );
    }
    /**
     * Visszatér a nyelv aktív értékével.
     * @return int
     */
    public function get_nyelvtudas_nyelv_aktiv()
    {
        return $this->readBitAttribute('nyelvtudas_nyelv_aktiv');
    }
    /**
     * Visszatér a nyelv törölt értékével.
     * @return int
     */
    public function get_nyelvtudas_nyelv_torolt()
    {
        return $this->readBitAttribute('nyelvtudas_nyelv_torolt');
    }
    /**
     * Visszatér a név minimális hosszával.
     * @return int
     */
    public function getNameMin()
    {
        return $this->nameMin;
    }
    /**
     * Visszatér a név maximális hosszával.
     * @return int
     */
    public function getNameMax()
    {
        return $this->nameMax;
    }
    /**
     * Beállítja az aktív mező értékét.
     * @param int $value
     */
    public function set_nyelvtudas_nyelv_aktiv($value)
    {
        $this->assignBitAttribute('nyelvtudas_nyelv_aktiv', $value);
    }
    /**
     * Beállítja a törölt mező értékét.
     * @param int $value
     */
    public function set_nyelvtudas_nyelv_torolt($value)
    {
        $this->assignBitAttribute('nyelvtudas_nyelv_torolt', $value);
    }
}