<?php
/**
 * Felhasználó munkaerő piaci helyzete ActiveRecord Model.
 * 
 * @property int $ugyfel_id Felhasználó azonosító, akihez tartoznak az adatok.
 * @property int $palyakezdo Pályakezdő-e.
 * @property int $regisztralt_munkanelkuli Regisztrált munkanélküli-e.
 * @property ActiveRecord\DateTime $mikor_regisztralt Mikor regisztrált.
 * @property int $gyes_gyed_visszatero GYES-ről, GYED-ről visszatérő?
 * @property ActiveRecord\DateTime $gyes_gyed_lejar_datum Mikor jár le a GYES, GYED?
 * @property int $megvaltozott_mkepessegu Megváltozott munkaképességű-e?
 * @property ActiveRecord\DateTime $kov_felulv_date Következő felülvizsgálat ideje.
 * @property string $mvegzes_keok Munkavégzést korlátozó egyéb okok.
 * @property int $dolgozik Dolgozik
 * @property string $dolgozik_nev Cég neve, ha dolgozik.
 * @property string $dolgozik_cim Cég címe, ha dolgozik.
 * @property string $dolgozik_munkakor Munkakör neve, amiben dolgozik, ha dolgozik.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class LaborMarket extends \ArEditable implements \IClientSave
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_mp_helyzet';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
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
     * Mezők által felvehető értékek validációs szabályok.
     * @var array
     */
    public static $validates_inclusion_of = array();
    /**
     * Mezők értékeinek formátumára vonatkozó validációs szabályok.
     * @var array
     */
    public static $validates_format_of = array();
    
    public static $belongs_to = array(
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

    public function after_construct()
    {
        static::$validates_inclusion_of = array(
            array(
                'palyakezdo',
                'in' => array(0, 1, null),
                'message' => 'A "Pályakezdő-e ?" mező csak igen-nem, vagy üres értéket vehet fel!'
            ),
            array(
                'regisztralt_munkanelkuli',
                'in' => array(0, 1, null),
                'message' => 'A "Regisztrált munkanélküli-e ?" mező csak igen-nem, vagy üres értéket vehet fel!'
            ),
            array(
                'gyes_gyed_visszatero',
                'in' => array(0, 1, null),
                'message' => 'A "GYES-ről, GYED-ről visszatérő ?" mező csak igen-nem, vagy üres értéket vehet fel!'
            ),
            array(
                'megvaltozott_mkepessegu',
                'in' => array(0, 1, null),
                'message' => 'A "Megváltozott munkaképességű-e ?" mező csak igen-nem, vagy üres értéket vehet fel!'
            ),
            array(
                'dolgozik',
                'in' => array(0, 1, null),
                'message' => 'A "Dolgozik" mező csak igen-nem, vagy üres értéket vehet fel!'
            )
        );
        static::$validates_format_of = array(
            array(
                'mikor_regisztralt',
                'allow_blank' => true,
                'with' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
                'message' => 'A formátum nem megfelelő!'
            ),
            array(
                'gyes_gyed_lejar_datum',
                'allow_blank' => true,
                'with' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
                'message' => 'A formátum nem megfelelő!'
            ),
            array(
                'kov_felulv_date',
                'allow_blank' => true,
                'with' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
                'message' => 'A formátum nem megfelelő!'
            )
        );
    }
    /**
     * Létrehozás előtt lefutó metódus.
     * @return boolean
     * @throws \ActiveRecord\ModelException
     */
    public function before_create()
    {
        if (!$this->isAttributeSet('ugyfel_id')) {
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
        if ($this->isAttributeSet('ugyfel_id')) {
            throw new \ActiveRecord\ModelException(
                'A felhasználó azonosító megváltozott, ezért az adatok nem menthetőek!'
            );
        } else {
            return parent::before_update();
        }
    }
    /**
     * Visszatér az attribútumok label-jeit tartalmazó tömbbel.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'ugyfel_id' => 'Felhasználó azonosító',
            'palyakezdo' => 'Pályakezdő',
            'regisztralt_munkanelkuli' => 'Regisztrált munkanélküli-e?',
            'mikor_regisztralt' => 'Mikor regisztrált?',
            'gyes_gyed_visszatero' => 'GYED-ről, GYES-ről visszatérő',
            'gyes_gyed_lejar_datum' => 'Mikor jár le ?',
            'megvaltozott_mkepessegu' => 'Megváltozott munkaképességű',
            'kov_felulv_date' => 'Következő felülvizsgálat ideje',
            'mvegzes_keok' => 'Munkavégzést korlátozó egyéb okok (pl. bármilyen betegség, ápolási díjban részesül)',
            'dolgozik' => 'Dolgozik',
            'dolgozik_nev' => 'Hol dolgozik (cég neve)',
            'dolgozik_cim' => 'Hol dolgozik (cég címe)',
            'dolgozik_munkakor' => 'Milyen munkakörben dolgozik',
            'letrehozo_id' => 'Létrehozó azonosító',
            'modosito_id' => 'Módosító azonosító',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma'
        );
    }
    /**
     * Visszatér a pályakezdő mező értékével. (0-1)
     * @return int
     */
    public function get_palyakezdo()
    {
        return $this->readBitAttribute('palyakezdo');
    }
    /**
     * Visszatér a regisztrált munkanélküli mező értékvel. (0-1)
     * @return int
     */
    public function get_regisztralt_munkanelkuli()
    {
        return $this->readBitAttribute('regisztralt_munkanelkuli');
    }
    /**
     * Visszatér a GYES-GYED visszatérő mező értékével. (0-1)
     * @return int
     */
    public function get_gyes_gyed_visszatero()
    {
        return $this->readBitAttribute('gyes_gyed_visszatero');
    }
    /**
     * Visszatér a megváltozott munkaképességű mező értékével. (0-1)
     * @return int
     */
    public function get_megvaltozott_mkepessegu()
    {
        return $this->readBitAttribute('megvaltozott_mkepessegu');
    }
    /**
     * Visszatér a dolgozik mező értékével. (0-1)
     * @return int
     */
    public function get_dolgozik()
    {
        return $this->readBitAttribute('dolgozik');
    }
    /**
     * Visszatér a "Mikor regisztrált" mező formázott értékével.
     * @return string
     */
    public function get_mikor_regisztralt()
    {
        return $this->readDateTimeAttribute('mikor_regisztralt');
    }
    /**
     * Visszatér a "Mikor jár le a GYES, GYED ?" mező formázott értékével.
     * @return string
     */
    public function get_gyes_gyed_lejar_datum()
    {
        return $this->readDateTimeAttribute('gyes_gyed_lejar_datum');
    }
    
    public function getMikorRegisztraltFormatted($format = ArBase::DEFAULT_DATETIME_FORMAT)
    {
        return $this->getDateTimeFormatted($this->read_attribute('mikor_regisztralt'), $format);
    }
    
    public function getGyesGyedLejarDatumFormatted($format = ArBase::DEFAULT_DATETIME_FORMAT)
    {
        return $this->getDateTimeFormatted($this->read_attribute('gyes_gyed_lejar_datum'), $format);
    }
    
    public function getKovFelulvDateFormatted($format = ArBase::DEFAULT_DATETIME_FORMAT)
    {
        return $this->getDateTimeFormatted($this->read_attribute('kov_felulv_date'), $format);
    }
    /**
     * Visszatér a "Következő felülvizsgálat ideje" mező formázott értékével.
     * @return string
     */
    public function get_kov_felulv_date()
    {
        return $this->readDateTimeAttribute('kov_felulv_date');
    }
    /**
     * Beállítja a "Pályakezdő" mező értékét.
     * @param mixed $value
     */
    public function set_palyakezdo($value)
    {
        $this->assignBitAttribute('palyakezdo', $value);
    }
    /**
     * Beállítja a "Regisztrált munkanélküli" mező értékét.
     * @param mixed $value
     */
    public function set_regisztralt_munkanelkuli($value)
    {
        $this->assignBitAttribute('regisztralt_munkanelkuli', $value);
    }
    /**
     * Beállítja a "GYES-GYED visszatérő" mező értékét.
     * @param mixed $value
     */
    public function set_gyes_gyed_visszatero($value)
    {
        $this->assignBitAttribute('gyes_gyed_visszatero', $value);
    }
    /**
     * Beállítja a "Megváltozott munkaképességű" mező értékét.
     * @param mixed $value
     */
    public function set_megvaltozott_mkepessegu($value)
    {
        $this->assignBitAttribute('megvaltozott_mkepessegu', $value);
    }
    /**
     * Beállítja a "Dolgozik" mező értékét.
     * @param mixed $value
     */
    public function set_dolgozik($value)
    {
        $this->assignBitAttribute('dolgozik', $value);
    }
    /**
     * Beállítja a munkavégzést korlátozó egyéb okok (pl. bármilyen betegség, ápolási díjban részesül) értékét 
     * tároló mező értékét. (Trimeli!)
     * @param string $value
     */
    public function set_mvegzes_keok($value)
    {
        $this->assign_attribute('mvegzes_keok', trim($value));
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