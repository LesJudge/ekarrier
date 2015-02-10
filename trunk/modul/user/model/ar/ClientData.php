<?php
/**
 * @property int $user_id Felhasználó azonosító.
 * @property int $user_allapot_id Ügyfél állapot azonosító.
 * @property int $munkakor_kategoria Munkakör kategória.
 * @property int $munkaba_allas_allapot Munkába állás állapot.
 * @property int $vegzettseg_id Végzettség azonosító.
 * @property string $egyeb_munkakorok_erdeklik Egyéb munkakörök érdeklik.
 * @property string $nem Ügyfél neme.
 * @property string $anyja_neve Anyja neve.
 * @property string $telefonszam_vezetekes Vezetékes telefonszám.
 * @property string $telefonszam_mobil1 Elsődleges mobilszám.
 * @property string $telefonszam_mobil2 Másodlagos mobilszám.
 * @property mixed $kapcsolatfelvetel_ideje Kapcsolatfelvétel ideje.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property \Client $client Ügyfél objektum.
 * @property \User $creator Létrehozó user objektum.
 * @property \User $modificatory Módosító user objektum.
 * @property \City $city Város.
 * @property \County $county Megye.
 */
class ClientData extends \ArEditable implements \IClientSave
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'user_ugyfel';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'user_id';
    /**
     * Kötelező mezők.
     * @var array
     */
    public static $validates_presence_of = array();
    /**
     * Mezők értékeinek hosszára vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array();
    /**
     * Mezők értékeinek "formájára" vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_format_of = array();
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array(
        'user_id',
        'letrehozo_id',
        'modosito_id',
        'letrehozas_timestamp',
        'modositas_timestamp',
        'modositas_szama'
    );
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Ügyfél kapcsolat.
        array(
            'client',
            'class_name' => 'Client',
            'foreign_key' => 'user_id',
            'read_only' => true
        ),
        // Létrehozó kapcsolat.
        array(
            'creator',
            'class_name' => 'User',
            'foreign_key' => 'letrehozo_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login, user_aktiv, user_torolt'
        ),
        // Módosító kapcsolat.
        array(
            'modificatory',
            'class_name' => 'User',
            'foreign_key' => 'modosito_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login, user_aktiv, user_torolt'
        ),
        // Státusz kapcsolat.
        array(
            'status',
            'class_name' => 'ClientStatus',
            'foreign_key' => 'user_allapot_id',
            'read_only' => true
        )
    );
    /**
     * Konstruktor
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
        $this->modifyAttributes($attributes);
        parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    }
    /**
     * Attribútum értékek módosítása.
     * @param array $attributes
     */
    protected function modifyAttributes(array &$attributes)
    {
        $unset = array(
            'user_allapot_id',
            'munkakor_kategoria',
            'munkaba_allas_allapot',
            'vegzettseg_id',
            'kapcsolatfelvetel_ideje'
        );
        foreach ($unset as $attr) {
            if (isset($attributes[$attr]) && (int)$attributes[$attr] == 0) {
                unset($attributes[$attr]);
            }
        }
    }
    /**
     * Attribútumok értékeinek beállítása.
     * @param array $attributes
     */
    public function set_attributes(array $attributes)
    {
        $this->modifyAttributes($attributes);
        parent::set_attributes($attributes);
    }
    /**
     * Inicializálás végén lefutó metódus.
     */
    public function after_construct()
    {
        $phonePattern = static::regexPhoneNumber();
        static::$validates_format_of = array(
            array(
                'telefonszam_vezetekes',
                'allow_blank' => true,
                'with' => $phonePattern,
                'message' => 'A telefonszám nem megfelelő! (pl. 3650123456)'
            ),
            array(
                'telefonszam_mobil1',
                'allow_blank' => true,
                'with' => $phonePattern,
                'message' => 'A telefonszám nem megfelelő! (pl. 36501234567)'
            ),
            array(
                'telefonszam_mobil2',
                'allow_blank' => true,
                'with' => $phonePattern,
                'message' => 'A telefonszám nem megfelelő! (pl. 36501234567)'
            )
        );
        $telLength = static::getTelephoneLength();
        static::$validates_length_of = array(
            array(
                'telefonszam_vezetekes',
                'allow_blank' => true,
                'within' => $telLength,
                'too_short' => 'A telefonszámnak legalább ' . $telLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A telefonszám legfeljebb ' . $telLength[1] - 1 . ' karakter hosszú lehet!'
            ),
            array(
                'telefonszam_mobil1',
                'allow_blank' => true,
                'within' => $telLength,
                'too_short' => 'A mobiltelefonszámnak legalább ' . $telLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A mobiltelefonszámnak legfeljebb ' . $telLength[1] . ' karakter hosszú lehet!'
            ),
            array(
                'telefonszam_mobil2',
                'allow_blank' => true,
                'within' => $telLength,
                'too_short' => 'A mobiltelefonszámnak legalább ' . $telLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'A mobiltelefonszámnak legfeljebb ' . $telLength[1] . ' karakter hosszú lehet!'
            )
        );
    }
    /**
     * Visszatér az attribútumok label-jeit tartalmazó tömbbel.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'Felhasználó azonosító',
            'munkakor_kategoria' => 'Munkakör kategória',
            'munkaba_allas_allapot' => 'Munkába állás állapot',
            'vegzettseg_id' => 'Legmagasabb iskolai végzettség',
            'user_allapot_id' => 'Állapot',
            'nem' => 'Neme',
            'anyja_neve' => 'Anyja neve',
            'egyeb_munkakorok_erdeklik' => 'Egyéb munkakörök érdeklik',
            'telefonszam_vezetekes' => 'Vezetékes telefonszám',
            'telefonszam_mobil1' => 'Mobiltelefonszám - elsődleges',
            'telefonszam_mobil2' => 'Mobiltelefonszám - másodlagos',
            'kapcsolatfelvetel_ideje' => 'Kapcsolatfelvétel ideje'
        );
    }
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     */
    public static function model($param = null)
    {
        if (static::isNaturalNoZeroNumber($param)) {
            return static::find($param);
        } else {
            $class = get_called_class();
            return new $class;
        }
    }
    /**
     * "Set-up"-olja az objektumot az ügyfél mentéshez.
     * @param \Client $client
     * @return \self
     */
    public function setUpClientSave(\Client $client)
    {
        $this->user_id = $client->user_id;
        return $this;
    }
    /**
     * Visszatér a telefonszám minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public static function getTelephoneLength()
    {
        return array(10, 11);
    }
    /**
     * Visszatér a házszám minimális és maximális hosszát tartalmazó tömbbel.
     * @return array
     */
    public static function getAddressHouseNumberLength()
    {
        return array(1, 32);
    }
    /**
     * Visszatér a telefonszám validáláshoz tartozó reguláris kifejezéssel.
     * @return string
     */
    public static function regexPhoneNumber()
    {
        //return '/^\36\d{8,9}$/';
        return '/^36[0-9]{8,9}$/';
    }
}