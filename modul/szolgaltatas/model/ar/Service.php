<?php
/**
 * Szolgáltatás ActiveRecord Model.
 * 
 * @property int $szolgaltatas_id Szolgáltatás azonosító.
 * @property string $szolgaltatas_nev Szolgáltatás neve.
 * @property string $szolgaltatas_leiras Szolgáltatás leírása.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítások száma.
 * @property int $szolgaltatas_aktiv Aktív-e a képzés.
 * @property int $szolgaltatas_torolt Törölt-e a képzés.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class Service extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    static $table_name = 'szolgaltatas';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    static $primary_key = 'szolgaltatas_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    static $attr_protected = array(
        'szolgaltatas_id',
        'letrehozo_id',
        'modosito_id',
        'letrehozas_timestamp',
        'modositas_timestamp',
        'modositas_szama'
    );
    /**
     * Alias példányváltozók.
     * @var array
     */
    static $alias_attribute = array(
        'label' => 'szolgaltatas_nev',
        'value' => 'szolgaltatas_id'
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    static $validates_presence_of = array(
        array(
            'szolgaltatas_nev',
            'message' => 'Kötelező mező!'
        )
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    static $validates_length_of = array();
    /**
     * Létrehozás idejét tároló mező neve.
     * @var mixed
     */
    protected $createdAttribte = 'letrehozas_timestamp';
    /**
     * Módosítás idejét tároló mező neve.
     * @var mixed
     */
    protected $modifiedAttribute = 'modositas_timestamp';
    /**
     * Létrehozó felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $creatorAttribute = 'letrehozo_id';
    /**
     * Módosító felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $modificatoryAttribute = 'modosito_id';
    /**
     * Módosítások számát tároló mező neve.
     * @var mixed
     */
    protected $nomAttribute = 'modositas_szama';
    /**
     * Konstruktor felüldeklarálása.
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
        $nameLength = $this->get_szolgaltatas_nev_length();
        self::$validates_length_of = array(
            array(
                'szolgaltatas_nev',
                'within' => $nameLength,
                'too_short' => 'Legalább ' . $nameLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'Legfeljebb ' . $nameLength[1] . ' karakter hosszú lehet!'
            )
        );
    }
    /**
     * Autocomplete-nek megfelelő JSON formátumúvá alakítja a paraméterül adott eredményhalmazt.
     * @param array $result Eredményhalmaz.
     * @return string
     * @throws UnexpectedValueException
     */
    public static function toAutocomplete(array $result)
    {
        $autocomplete = array();
        foreach ($result as $model) {
            if ($model instanceof self) {
                $autocomplete[] = array(
                    'label' => $model->label,
                    'value' => $model->value
                );
            } else {
                throw new UnexpectedValueException('A modelnek a ' . __CLASS__ . ' osztályból kell származnia.');
            }
        }
        return json_encode($autocomplete);
    }
    /**
     * Visszatér a szolgaltatas_nev mező minimális és maximális hosszával.
     * @return array
     */
    public function get_szolgaltatas_nev_length()
    {
        return array(3, 128);
    }
    /**
     * Beállítja a szolgaltatas_nev mező értékét.
     * @param string $szolgaltatas_nev
     */
    public function set_szolgaltatas_nev($szolgaltatas_nev)
    {
        $this->assign_attribute('szolgaltatas_nev', trim($szolgaltatas_nev));
    }
    /**
     * Beállítja a szolgaltatas_leiras mező értékét.
     * @param string $szolgaltatas_leiras
     */
    public function set_szolgaltatas_leiras($szolgaltatas_leiras)
    {
        $this->assign_attribute('szolgaltatas_leiras', trim($szolgaltatas_leiras));
    }
}