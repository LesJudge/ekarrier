<?php
/**
 * Felhasználó végzettség ActiveRecord Model.
 * 
 * @property int $ugyfel_attr_vegzettseg_id Végzettség azonosító.
 * @property int $nyelv_id Nyelv azonosító.
 * @property int $vegzettseg_id Végzettség azonosító.
 * @property string $ugyfel_attr_vegzettseg_iskola Iskola.
 * @property int $ugyfel_attr_vegzettseg_kezdet Kezdés éve.
 * @property int $ugyfel_attr_vegzettseg_veg Végzés éve.
 * @property string $ugyfel_attr_vegzettseg_szak Szak.
 * @property string $ugyfel_attr_vegzettseg_megnevezes Megnevezés.
 * @property ActiveRecord\DateTime $ugyfel_attr_vegzettseg_letrehozas_datum Végzettség létrehozásának ideje.
 * @property ActiveRecord\DateTime $ugyfel_attr_vegzettseg_modositas_datum Végzettség módosításának ideje.
 * @property int $ugyfel_attr_vegzettseg_letrehozo Végzettség létrehozójának azonosítója.
 * @property int $ugyfel_attr_vegzettseg_modosito Végzettség módosítójának azonosítója.
 * @property int $ugyfel_attr_vegzettseg_modositas_szama Végzettség módosításának száma.
 * @property int $ugyfel_attr_vegzettseg_aktiv Aktív-e a végzettség.
 * @property int $ugyfel_attr_vegzettseg_torolt Törölt-e a végzettség.
 * @property Client $client Ügyfél adatai.
 * @property User $creator Végzettség létrehozójának adatai.
 * @property User $modificatory Végzettség módosítójának adatai.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class UserEducation extends \ArEditable implements \ISheepItAble, \IClientSave
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_vegzettseg';
    /**
     * Tábla elsődleges kulcsa.
     * @var array
     */
    public static $primary_key = 'ugyfel_attr_vegzettseg_id';
    /**
     * Kötelező mezők validációs szabályai.
     * @var array
     */
    public static $validates_presence_of = array(
        array('vegzettseg_id', 'message' => 'A végzettség megadása kötelező!')
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array();
    
    public static $validates_numericality_of = array();
    
    public static $belongs_to = array(
        // Ügyfél kapcsolat.
        array(
            'client',
            'class_name' => 'Client',
            'foreign_key' => 'ugyfel_id',
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
        // Végzettség kapcsolat.
        array(
            'education',
            'class_name' =>'Education',
            'foreign_key' => 'vegzettseg_id',
            'read_only' => true
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
     * Létrehozás idejét tároló mező neve.
     * @var mixed
     */
    protected $createdAttribte = 'ugyfel_attr_vegzettseg_letrehozas_datum';
    /**
     * Módosítás idejét tároló mező neve.
     * @var mixed
     */
    protected $modifiedAttribute = 'ugyfel_attr_vegzettseg_modositas_datum';
    /**
     * Létrehozó felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $creatorAttribute = 'ugyfel_attr_vegzettseg_letrehozo';
    /**
     * Módosító felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $modificatoryAttribute = 'ugyfel_attr_vegzettseg_modosito';
    /**
     * Módosítások számát tároló mező neve.
     * @var mixed
     */
    protected $nomAttribute = 'ugyfel_attr_vegzettseg_modositas_szama';

    public function after_construct()
    {
        $schoolLength = static::getSchoolLength();
        $depLength = static::getDepLength();
        // Példányváltozók méret szabályai.
        static::$validates_length_of = array(
            array(
                'ugyfel_attr_vegzettseg_iskola',
                'allow_blank' => true,
                'within' => $schoolLength,
                'too_short' => 'Legalább ' . $schoolLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'Legfeljebb ' . $schoolLength[1] . ' karakter hosszú lehet!'
            ),
            array(
                'ugyfel_attr_vegzettseg_szak',
                'allow_blank' => true,
                'within' => $depLength,
                'too_short' => 'Legalább ' . $depLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'Legfeljebb ' . $depLength[1] . ' karakter hosszú lehet!'
            ),
        );
        /*
        static::$validates_numericality_of = array(
            array(
                'ugyfel_attr_vegzettseg_kezdet',
                'less_than_or_equal_to' => date('Y') - $this->getYearDiff()
            ),
            array(
                'ugyfel_attr_vegzettseg_veg',
                'less_than_or_equal_to' => date('Y')
            )
        );
        */
    }
    /**
     * Attribútumok neveit tartalmazó tömb.
     * @return array
     */
    public function attributeLabels()
    {
        $tableName = static::table_name();
        return array(
            'ugyfel_attr_vegzettseg_id' => 'Végzettség azonosító',
            'nyelv_id' => 'Nyelv',
            'ugyfel_id' => 'Felhasználó',
            'vegzettseg_id' => 'Végzettség típus',
            $tableName . '_iskola' => 'Iskola',
            $tableName . '_kezdet' => 'Kezdés éve',
            $tableName . '_veg' => 'Végzés éve',
            $tableName . '_szak' => 'Szak',
            $tableName . '_megnevezes' => 'Megnevezés',
            $tableName . '_letrehozas_datum' => 'Létrehozva',
            $tableName . '_modositas_datum' => 'Módosítva',
            $tableName . '_letrehozo' => 'Létrehozó',
            $tableName . '_modosito' => 'Módosító',
            $tableName . '_modositas_szama' => 'Módosítás száma',
            $tableName . '_aktiv' => 'Aktív',
            $tableName . '_torolt' => 'Törölt'
        );
    }
    /**
     * Lekérdezi a felhasználóhoz tartozó összes aktív, nem törölt végzettség rekordot.
     * @param int $userId Felhasználó azonosító.
     * @return array
     * @throws InvalidArgumentException
     */
    public static function findEducationsByUserId($userId)
    {
        if (self::validateAiId($userId)) {
            return self::find('all', array(
                'conditions' => array(
                    static::$table_name . '_aktiv' => 1,
                    static::$table_name . '_torolt' => 0,
                    'ugyfel_id' => (int)$userId
                )
            ));
        }
    }
    /**
     * Visszatér az iskola nevének minimális és maximális hosszával.
     * @return array
     */
    public static function getSchoolLength()
    {
        return array(10, 255);
    }
    /**
     * Visszatér a szak nevének minimális és maximális hosszával.
     * @return array
     */
    public static function getDepLength()
    {
        return array(3, 70);
    }
    /**
     * Visszatér az év különbség értékével.
     * @return int
     */
    public static function getYearDiff()
    {
        return 2;
    }
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return 'educationForm_#index#';
    }
    /**
     * Visszatér a végrehajtandó SQL Query-vel.
     * @return string
     */
    public function sheepItSaveQuery()
    {
        return 'INSERT INTO ' . static::$table_name . '
                (
                    ' . static::$table_name . '_id,
                    nyelv_id,
                    ugyfel_id,
                    vegzettseg_id,
                    ' . static::$table_name . '_iskola,
                    ' . static::$table_name . '_kezdet,
                    ' . static::$table_name . '_veg,
                    ' . static::$table_name . '_szak,
                    ' . static::$table_name . '_megnevezes,
                    ' . static::$table_name . '_letrehozo,
                    ' . static::$table_name . '_modosito,
                    ' . static::$table_name . '_aktiv,
                    ' . static::$table_name . '_torolt
                ) 
                VALUES (?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 0) 
                ON DUPLICATE KEY UPDATE
                vegzettseg_id = ?,
                ' . static::$table_name . '_iskola = ?,
                ' . static::$table_name . '_kezdet = ?,
                ' . static::$table_name . '_veg = ?,
                ' . static::$table_name . '_szak = ?,
                ' . static::$table_name . '_megnevezes = ?,
                ' . static::$table_name . '_modosito = ?,
                ' . static::$table_name . '_modositas_datum = NOW(),
                ' . static::$table_name . '_modositas_szama = ' . static::$table_name . '_modositas_szama + 1,
                ' . static::$table_name . '_aktiv = 1,
                ' . static::$table_name . '_torolt = 0';
    }
    /**
     * Visszatér a query-hez elkészített tömbbel.
     * @return array Query-hez elkészített tömb.
     */
    public function sheepItSaveValue()
    {
        $userId = (int)UserLoginOut_Controller::$_id;
        return array(
            ($this->ugyfel_attr_vegzettseg_id > 0) ? $this->ugyfel_attr_vegzettseg_id : null,
            $this->ugyfel_id,
            $this->vegzettseg_id,
            $this->ugyfel_attr_vegzettseg_iskola,
            $this->ugyfel_attr_vegzettseg_kezdet,
            $this->ugyfel_attr_vegzettseg_veg,
            $this->ugyfel_attr_vegzettseg_szak,
            $this->ugyfel_attr_vegzettseg_megnevezes,
            $userId,
            $userId,
            $this->vegzettseg_id,
            $this->ugyfel_attr_vegzettseg_iskola,
            $this->ugyfel_attr_vegzettseg_kezdet,
            $this->ugyfel_attr_vegzettseg_veg,
            $this->ugyfel_attr_vegzettseg_szak,
            $this->ugyfel_attr_vegzettseg_megnevezes,
            $userId
        );
    }
    /**
     * JSON formátumúvá alakítja a modelt.
     * @return array SheepItForm adatai JSON formátumban.
     */
    public function sheepIt2Serializable()
    {
        $prefix = $this->sheepItPrefix();
        $jsonData = array(
            $prefix . '_ugyfel_attr_vegzettseg_id' => $this->read_attribute('ugyfel_attr_vegzettseg_id'),
            $prefix . '_vegzettseg_id' => $this->read_attribute('vegzettseg_id'),
            $prefix . '_ugyfel_attr_vegzettseg_iskola'
            =>
            $this->read_attribute('ugyfel_attr_vegzettseg_iskola'),
            $prefix . '_ugyfel_attr_vegzettseg_kezdet'
            =>
            $this->get_ugyfel_attr_vegzettseg_kezdet(),
            $prefix . '_ugyfel_attr_vegzettseg_veg' => $this->get_ugyfel_attr_vegzettseg_veg(),
            $prefix . '_ugyfel_attr_vegzettseg_szak' => $this->read_attribute('ugyfel_attr_vegzettseg_szak'),
            $prefix . '_ugyfel_attr_vegzettseg_megnevezes' => $this->read_attribute('ugyfel_attr_vegzettseg_megnevezes')
        );
        $errors = $this->errors;
        $closure = function(&$jsonData, $attribute) use($errors, $prefix) {
            $error = null;
            if (is_object($errors) && ($error = $errors->on($attribute))) {
                $error = ArErrorRenderer::processErrorMessage($error);
            }
            $jsonData[$prefix . '_' . $attribute . '_error'] = $error;
        };
        $closure($jsonData, 'ugyfel_attr_vegzettseg_id');
        $closure($jsonData, 'vegzettseg_id');
        $closure($jsonData, 'ugyfel_attr_vegzettseg_iskola');
        $closure($jsonData, 'ugyfel_attr_vegzettseg_kezdet');
        $closure($jsonData, 'ugyfel_attr_vegzettseg_veg');
        $closure($jsonData, 'ugyfel_attr_vegzettseg_szak');
        $closure($jsonData, 'ugyfel_attr_vegzettseg_megnevezes');
        return $jsonData;
    }
    /**
     * Törli az összes sheepIt rekordot.
     */
    public function sheepItDelete()
    {
        $query = 'UPDATE ' . static::$table_name . ' SET ' . static::$table_name . '_torolt = 1 WHERE ugyfel_id = ?';
        self::query($query, array($this->ugyfel_id));
    }
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     * @return \UserEducation
     */
    public static function model($param = null)
    {
        $class = get_called_class();
        return new $class;
    }
    /**
     * "Set-up"-olja az objektumot az ügyfél mentéshez.
     * @param \Client $client
     * @return \UserEducation
     */
    public function setUpClientSave(\Client $client)
    {
        $this->flag_dirty('vegzettseg_id');
        $this->ugyfel_id = $client->ugyfel_id;
        return $this;
    }
    /**
     * Törölheti-e a rekord(okat) UPDATE előtt.
     * @return boolean
     */
    public function canDeleteBeforeUpdate()
    {
        return true;
    }
    
    public function get_ugyfel_attr_vegzettseg_kezdet()
    {
        $kezdet = $this->read_attribute('ugyfel_attr_vegzettseg_kezdet');
        return $kezdet > 0 ? $kezdet : null;
    }
    
    public function get_ugyfel_attr_vegzettseg_veg()
    {
        $veg = $this->read_attribute('ugyfel_attr_vegzettseg_veg');
        return $veg > 0 ? $veg : null;
    }
}