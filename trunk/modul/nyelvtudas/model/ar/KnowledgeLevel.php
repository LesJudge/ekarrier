<?php
/**
 * Nyelvtudás szint ActiveRecord model.
 * 
 * @property int $nyelvtudas_szint_id Szint azonosító.
 * @property int $nyelvtudas_szint_nev Szint neve.
 * @property int $nyelvtudas_szint_letrehozo Létrehozó felhasználó azonosítója.
 * @property int $nyelvtudas_szint_modosito Módosító felhasználó azonosítója.
 * @property ActiveRecord\DateTime $nyelvtudas_szint_letrehozas_datum Létrehozás ideje.
 * @property ActiveRecord\DateTime $nyelvtudas_szint_modositas_datum Módosítás ideje.
 * @property int $nyelvtudas_szint_modositas_szama Módosítás száma.
 * @property int $nyelvtudas_szint_aktiv Aktív-e.
 * @property int $nyelvtudas_szint_torolt Törölve lett-e a rekord.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class KnowledgeLevel extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    static $table_name = 'nyelvtudas_szint';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    static $primary_key = 'nyelvtudas_szint_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    static $attr_protected = array(
        'nyelvtudas_szint_letrehozo',
        'nyelvtudas_szint_modosito',
        'nyelvtudas_szint_letrehozas_datum',
        'nyelvtudas_szint_modositas_datum',
        'nyelvtudas_szint_modositas_szama'
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    static $validates_presence_of = array(
        array(
            'nyelvtudas_szint_nev',
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
    protected $createdAttribte = 'nyelvtudas_szint_letrehozas_datum';
    /**
     * Módosítás idejét tároló mező neve.
     * @var mixed
     */
    protected $modifiedAttribute = 'nyelvtudas_szint_modositas_datum';
    /**
     * Létrehozó felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $creatorAttribute = 'nyelvtudas_szint_letrehozo';
    /**
     * Módosító felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $modificatoryAttribute = 'nyelvtudas_szint_modosito';
    /**
     * Módosítások számát tároló mező neve.
     * @var mixed
     */
    protected $nomAttribute = 'nyelvtudas_szint_modositas_szama';
    /**
     * Konstruktor.
     * @param array $attributes
     * @param boolean $guard_attributes
     * @param boolean $instantiating_via_find
     * @param boolean $new_record
     */
    public function __construct(array $attributes = array(), $guard_attributes = true, $instantiating_via_find = false, $new_record = true)
    {
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
        self::$validates_length_of = array(
            array(
                'nyelvtudas_szint_nev',
                'within' => array($this->getNameMin(), $this->getNameMax()),
                'too_short' => 'Legalább ' . $this->getNameMin() . ' karakter hosszúnak kell lennie!',
                'too_long' => 'Legfeljebb ' . $this->getNameMax() . ' karakter hosszú lehet!'
            )
        );
    }
    /**
     * Szűrő az aktív, nem törölt mezőkre.
     * @return array
     */
    public static function scopeActiveNotDeleted()
    {
        return array(
            'conditions' => array(
                'nyelvtudas_szint_aktiv = 1 AND nyelvtudas_szint_torolt = 0'
            )
        );
    }
    /**
     * Visszatér a rekord aktív értékével.
     * @return int
     */
    public function get_nyelvtudas_szint_aktiv()
    {
        return $this->readBitAttribute('nyelvtudas_szint_aktiv');
    }
    /**
     * Visszatér a rekord törölt értékvel.
     * @return int
     */
    public function get_nyelvtudas_szint_torolt()
    {
        return $this->readBitAttribute('nyelvtudas_szint_torolt');
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
    public function set_nyelvtudas_szint_aktiv($value)
    {
        $this->assignBitAttribute('nyelvtudas_szint_aktiv', $value);
    }
    /**
     * Beállítja a törölt mező értékét.
     * @param int $value
     */
    public function set_nyelvtudas_szint_torolt($value)
    {
        $this->assignBitAttribute('nyelvtudas_szint_torolt', $value);
    }
}