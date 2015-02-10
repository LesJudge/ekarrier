<?php
/**
 * Project információ ActiveRecord model.
 * 
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $eu_prog_elm_ket_ev Uniós finanszírozású programban részt vett-e az elmúlt 2 évben ?
 * @property int $hazai_prog_elm_ket_ev Hazai finanszírozású programban részt vett-e az elmúlt 2 évben?
 * @property int $koz_adatb_kerul Közvetítői adatbázisba kíván e kerülni?
 * @property int $hozjarul_munkakozv Hozzájárult-e munkaközvetítéshez?
 * @property int $mobilitast_vallal Mobilitást vállal e?
 * @property string $mobilitas_vallal_megjegyzes Megjegyzés a mobilitást vállal-e értékhez.
 * @property int $egy_megall_ktttnk_prog Együttműködési megállapodást kötöttünk-e vele a programba?
 * @property int $egy_megall_ktttnk_kepz Együttműködési megállapodást kötöttünk-e vele a képzésbe?
 * @property int $kepzes_bekerult Melyik képzésbe került be?
 * @property mixed $munkarend_id Munkarend azonosító.
 * @property mixed $hova_erkezett_id Hova érkezett be az ügyfél.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property \ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property int $modositas_szama Módosítás száma.
 * @property \CameTo $cameto Hova érkezett be az ügyfél.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ProjectInformation extends \ArEditable implements \IClientSave
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_projekt_informacio';
    /**
     * Elsődleges kulcs.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
    /**
     * Modelhez tartozó 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Hova érkezett kapcsolat.
        array(
            'cameto',
            'class_name' => 'CameTo',
            'foreign_key' => 'hova_erkezett_id',
            'read_only' => true
        ),
        // Létrehozó kapcsolat.
        array(
            'creator',
            'class_name' => 'User',
            'foreign_key' => 'letrehozo_id',
            'read_only' => true,
            'select' => 'ugyfel_id, ugyfel_fnev, ugyfel_email, ugyfel_vnev, ugyfel_knev, ugyfel_last_login, ugyfel_aktiv, ugyfel_torolt'
        ),
        // Módosító kapcsolat.
        array(
            'modificatory',
            'class_name' => 'User',
            'foreign_key' => 'modosito_id',
            'read_only' => true,
            'select' => 'ugyfel_id, ugyfel_fnev, ugyfel_email, ugyfel_vnev, ugyfel_knev, ugyfel_last_login, ugyfel_aktiv, ugyfel_torolt'
        )
    );
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array(
        'ugyfel_id',
        'letrehozo_id',
        'modosito_id',
        'letrehozas_timestamp',
        'modositas_timestamp',
        'modositas_szama'
    );
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array();
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array();
    /**
     * Mezők által felvehető értékek validációs szabályok.
     * @var array
     */
    public static $validates_inclusion_of = array();

    public function after_construct()
    {
        // Táblában lévő összes BIT (0-1) attribútum.
        $incAttrs = array('eu_prog_elm_ket_ev', 'hazai_prog_elm_ket_ev', 'koz_adatb_kerul', 'hozjarul_munkakozv',
            'mobilitast_vallal', 'egy_megall_ktttnk_prog', 'egy_megall_ktttnk_kepz'
        );
        foreach($incAttrs as $inclusion) {
            static::$validates_inclusion_of[] = array(
                $inclusion,
                'allow_blank' => false,
                'in' => array(0, 1, null),
                'message' => 'Csak igen-nem értéket vehet fel!'
            ); // Validációs szabály hozzáadása a tömbhöz.
        }
    }
    /**
     * Létrehozás előtt lefutó metódus.
     * @return boolean
     * @throws \ActiveRecord\ModelException
     */
    public function before_create()
    {
        if (!$this->attribute_is_dirty('ugyfel_id')) {
            throw new \ActiveRecord\ModelException('Az adatok nem menthetőek, mert nincs felhasználóhoz rendelve!');
        } else {
            return parent::before_create();
        }
    }
    /**
     * Módosítás előtt lefutó metódus.
     * @return boolean
     * @throws \ActiveRecord\ModelException
     */
    public function before_update()
    {
        if ($this->attribute_is_dirty('ugyfel_id')) {
            throw new \ActiveRecord\ModelException(
                'A felhasználó azonosító megváltozott, ezért az adatok nem menthetőek!'
            );
        } else {
            return parent::before_update();
        }
    }
    /**
     * Visszatér az attribútumok neveit tartalmazó tömbbel.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'ugyfel_id' => 'Felhasználó azonosító',
            'eu_prog_elm_ket_ev' => 'Az elmúlt 2 évben Uniós finanszírozású foglalkoztatási programban részt vett-e ?',
            'hazai_prog_elm_ket_ev' => 'A programba bevonás idején hazai foglalkoztatási programban részt vett-e ?',
            'koz_adatb_kerul' => 'Kívánok a munkaerő közvetítői tevékenységrendszerükbe és adatbázisukba kerülni',
            'hozjarul_munkakozv' => 'Hozzájárult-e munkaközvetítéshez ?',
            'mobilitast_vallal' => 'Mobilitást vállal-e ?',
            'mobilitast_vallal_megjegyzes' => 'Megjegyzés (mobilitást vállal-e)',
            'egy_megall_ktttnk_prog' => 'Együttműködési megállapodást kötöttünk-e vele a programba ?',
            'egy_megall_ktttnk_kepz' => 'Együttműködési megállapodást kötöttünk-e vele a képzésbe ?',
            'kepzes_bekerult' => 'Melyik képzésbe került be ?',
            'munkarend_id' => 'Munkarend',
            'hova_erkezett_id' => 'Hova érkezett ?',
            'letrehozo_id' => 'Létrehozó azonosító',
            'modosito_id' => 'Módosító azonosító',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma'
        );
    }
    /**
     * Visszatér az "Uniós finanszírozású programban részt vett-e az elmúlt 2 évben ?" mező értékével. (0-1)
     * @return int
     */
    public function get_eu_prog_elm_ket_ev()
    {
        return $this->readBitAttribute('eu_prog_elm_ket_ev');
    }
    /**
     * Visszatér a "Hazai finanszírozású programban részt vett-e az elmúlt 2 évben ?" mező értékével. (0-1)
     * @return int
     */
    public function get_hazai_prog_elm_ket_ev()
    {
        return $this->readBitAttribute('hazai_prog_elm_ket_ev');
    }
    /**
     * Visszatér a "Közvetítői adatbázisba kíván e kerülni ?" mező értékével. (0-1)
     * @return int
     */
    public function get_koz_adatb_kerul()
    {
        return $this->readBitAttribute('koz_adatb_kerul');
    }
    /**
     * Visszatér a "Hozzájárult-e munkaközvetítéshez ?" mező értékével. (0-1)
     * @return int
     */
    public function get_hozjarul_munkakozv()
    {
        return $this->readBitAttribute('hozjarul_munkakozv');
    }
    /**
     * Visszatér a "Mobilitást vállal e ?" mező értékével. (0-1)
     * @return int
     */
    public function get_mobilitast_vallal()
    {
        return $this->readBitAttribute('mobilitast_vallal');
    }
    /**
     * Visszatér az "Együttműködési megállapodást kötöttünk-e vele a programba ?" mező érétkével. (0-1)
     * @return int
     */
    public function get_egy_megall_ktttnk_prog()
    {
        return $this->readBitAttribute('egy_megall_ktttnk_prog');
    }
    /**
     * Visszatér az "Együttműködési megállapodást kötöttünk-e vele a képzésbe ?" mező értékével. (0-1)
     * @return int
     */
    public function get_egy_megall_ktttnk_kepz()
    {
        return $this->readBitAttribute('egy_megall_ktttnk_kepz');
    }
    /**
     * Beállítja az "Uniós finanszírozású programban részt vett-e az elmúlt 2 évben ?" mező értékét.
     * @param mixed $value
     */
    public function set_eu_prog_elm_ket_ev($value)
    {
        $this->assignBitAttribute('eu_prog_elm_ket_ev', $value);
    }
    /**
     * Beállítja a "Hazai finanszírozású programban részt vett-e az elmúlt 2 évben ?" mező értékét.
     * @param mixed $value
     */
    public function set_hazai_prog_elm_ket_ev($value)
    {
        $this->assignBitAttribute('hazai_prog_elm_ket_ev', $value);
    }
    /**
     * Beállítja a "Közvetítői adatbázisba kíván e kerülni ?" mező értékét.
     * @param mixed $value
     */
    public function set_koz_adatb_kerul($value)
    {
        $this->assignBitAttribute('koz_adatb_kerul', $value);
    }
    /**
     * Beállítja a "Hozzájárult-e munkaközvetítéshez ?" mező értékét.
     * @param mixed $value
     */
    public function set_hozjarul_munkakozv($value)
    {
        $this->assignBitAttribute('hozjarul_munkakozv', $value);
    }
    /**
     * Beállítja a "Mobilitást vállal e ?" mező értékét.
     * @param mixed $value
     */
    public function set_mobilitast_vallal($value)
    {
        $this->assignBitAttribute('mobilitast_vallal', $value);
    }
    /**
     * Beállítja az "Együttműködési megállapodást kötöttünk-e vele a programba ?" mező értékét.
     * @param mixed $value
     */
    public function set_egy_megall_ktttnk_prog($value)
    {
        $this->assignBitAttribute('egy_megall_ktttnk_prog', $value);
    }
    /**
     * Beállítja az "Együttműködési megállapodást kötöttünk-e vele a képzésbe ?" mező értékét.
     * @param mixed $value
     */
    public function set_egy_megall_ktttnk_kepz($value)
    {
        $this->assignBitAttribute('egy_megall_ktttnk_kepz', $value);
    }
    /**
     * Beállítja a munkarend_id mező értékét.
     * @param mixed $munkarendId
     */
    public function set_munkarend_id($munkarendId)
    {
        if ($this->isNaturalNoZeroNumber($munkarendId) > 0) {
            $this->assign_attribute('munkarend_id', $munkarendId);
        }
    }
    /**
     * Beállítja a hova érkezett mező értékét.
     * @param mixed $hovaErkezettId
     */
    public function set_hova_erkezett_id($hovaErkezettId)
    {
        if ($this->isNaturalNoZeroNumber($hovaErkezettId)) {
            $this->assign_attribute('hova_erkezett_id', $hovaErkezettId);
        }
    }
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     */
    public static function model($param = null)
    {
        if (self::isNaturalNoZeroNumber($param)) {
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
        $this->ugyfel_id = $client->ugyfel_id;
        return $this;
    }
}