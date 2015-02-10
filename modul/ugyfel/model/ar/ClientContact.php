<?php
/**
 * @property int $ugyfel_attr_esetnaplo_id Esetnapló azonosító.
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property int $esetnaplo_tipus_id Esetnapló típus azonosító.
 * @property \ActiveRecord\DateTime $felvetel_ideje Kapcsolat felvétel ideje.
 * @property string $megjegyzes Megjegyzés.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property \ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 * @property Client $client Ügyfél adatai.
 * @property \ContactType $type Esetnapló bejegyzés típusa.
 */
class ClientContact extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    static $table_name = 'ugyfel_attr_esetnaplo';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    static $primary_key = 'ugyfel_attr_esetnaplo_id';
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    static $belongs_to = array(
        array(
            'client',
            'class_name' => 'Client',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'creator',
            'class_name' => 'User',
            'foreign_key' => 'letrehozo_id',
            'read_only' => true
        ),
        array(
            'modificatory',
            'class_name' => 'User',
            'foreign_key' => 'modosito_id',
            'read_only' => true
        ),
        array(
            'type',
            'class_name' => 'ContactType',
            'foreign_key' => 'esetnaplo_tipus_id',
            'read_only' => true
        )
    );
    /**
     * Constructor.
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
        self::$validates_presence_of = array(
            array(
                'felvetel_ideje',
                'message' => 'A felvétel ideje megadása kötelező!'
            ),
            array(
                'megjegyzes',
                'message' => 'A megjegyzés megadása kötelező!'
            )
        );
    }
    /**
     * Lekérdezi az ügyfélhez tartozó kapcsolatokat.
     * @param int $ugyfelId Felhasználó azonosító.
     * @return array
     */
    public static function findAllByClientId($ugyfelId)
    {
        return self::find('all', array(
            'conditions' => array('ugyfel_id' => $ugyfelId),
            'include' => array('creator', 'modificatory')
        ));
    }
    /**
     * Ügyfél azonosító alapján lekérdezi az aktív, nem törölt rekordokat.
     * @param int $clientId Ügyfél azonosító.
     * @return array
     */
    public static function scopeActiveNotDeletedByClient($clientId)
    {
        $scopeActive = self::scopeActiveNotDeleted();
        return array('conditions' => array('ugyfel_id' => $clientId) + $scopeActive['conditions']);
    }
    /**
     * Validáció.
     */
    public function validate()
    {
        if ($this->is_new_record()) {
            if (!$this->felvetel_ideje instanceof \ActiveRecord\DateTime) {
                $this->errors->add('felvetel_ideje', 'A felvétel idejének valós dátumot adjon meg!');
            }
            if ((int)$this->ugyfel_id == 0) {
                $this->errors->add('ugyfel_id', 'Hiányzó felhasználó azonosító!');
            }
            if ((int)$this->esetnaplo_tipus_id === 0) {
                $this->errors->add('esetnaplo_tipus_id', 'Hiányzó vagy nem megfelelő esetnapló típus!');
            }
        } else {
            if ($this->attribute_is_dirty('ugyfel_id')) {
                $this->errors->add('ugyfel_id', 'A felhasználó azonosítót nem módosíthatja!');
            }
        }
    }
}