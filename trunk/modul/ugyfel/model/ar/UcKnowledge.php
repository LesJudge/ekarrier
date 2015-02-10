<?php
/**
 * @property int $ugyfel_attr_szgep_ismeret_id Azonosító.
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property string $ismeret Számítógépes ismeret.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property User $ugyfel Felhasználó adatai.
 * @property User $creator Létrehozó felhasználó adatai.
 * @property User $modificatory Módosító felhasználó adatai.
 */
class UcKnowledge extends \ArEditable implements \ISheepItAble, \IClientSave
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_szgep_ismeret';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_szgep_ismeret_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array(
        //'ugyfel_attr_szgep_ismeret_id',
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
    public static $validates_presence_of = array(
        array(
            'ismeret',
            'message' => 'Kötelező mező!'
        ),
    );
    /**
     * Mezőkre vonatkozó string hossz validációs szabályok.
     * @var array
     */
    public static $validates_length_of = array();

    public function after_construct()
    {
        $knowledgeLength = static::getKnowledgeLength();
        static::$validates_length_of = array(
            array(
                'ismeret',
                'within' => $knowledgeLength,
                'too_short' => 'Legalább ' . $knowledgeLength[0] . ' karakter hosszúnak kell lennie!',
                'too_long' => 'Legfeljebb ' . $knowledgeLength[1] . ' karakter hosszú lehet!'
            )
        );
    }
    /**
     * Lekérdezi a felhasználóhoz tartoz összes számítógép ismeret rekordot.
     * @param int $userId
     * @return array
     * @throws InvalidArgumentException
     */
    public static function findComputerKnowledgesByUserId($userId)
    {
        if (self::validateAiId($userId)) {
            return self::find('all', array(
                'conditions' => array(
                    'ugyfel_id' => $userId,
                    static::$table_name . '_aktiv' => 1,
                    static::$table_name . '_torolt' => 0
                )
            ));
        }
    }
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return 'cKnowledgeForm_#index#';
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
                    ugyfel_id,
                    ismeret,
                    letrehozo_id,
                    modosito_id,
                    ' . static::$table_name . '_aktiv,
                    ' . static::$table_name . '_torolt
                )
                VALUES (?, ?, ?, ?, ?, 1, 0)
                ON DUPLICATE KEY UPDATE
                ismeret = ?,
                modosito_id = ?,
                modositas_timestamp = NOW(),
                modositas_szama = modositas_szama + 1,
                ' . static::$table_name . '_aktiv = 1,
                ' . static::$table_name . '_torolt = 0';
    }
    /**
     * Visszatér a query-hez elkészített tömbbel.
     * @return array Query-hez elkészített tömb.
     */
    public function sheepItSaveValue()
    {
        $userId = (int)UserLoginOut_Admin_Controller::$_id;
        return array(
            (int)$this->ugyfel_attr_szgep_ismeret_id > 0 ? $this->ugyfel_attr_szgep_ismeret_id : null,
            $this->ugyfel_id,
            $this->ismeret,
            $userId,
            $userId,
            $this->ismeret,
            $userId
        );
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
     * JSON formátumúvá alakítja a modelt.
     * @return array SheepItForm adatai JSON formátumban.
     */
    public function sheepIt2Serializable()
    {
        $prefix = $this->sheepItPrefix();
        $jsonData = array(
            $prefix . '_ugyfel_attr_szgep_ismeret_id' => $this->read_attribute('ugyfel_attr_szgep_ismeret_id'),
            $prefix . '_ismeret' => $this->read_attribute('ismeret')
        );
        $errors = $this->errors;
        $closure = function(&$jsonData, $attribute) use($errors, $prefix) {
            $error = null;
            if (is_object($errors) && ($error = $errors->on($attribute))) {
                $error = ArErrorRenderer::processErrorMessage($error);
            }
            $jsonData[$prefix . '_' . $attribute . '_error'] = $error;
        };
        $closure($jsonData, 'ugyfel_attr_szgep_ismeret_id');
        $closure($jsonData, 'ismeret');
        return $jsonData;
    }
    /**
     * Visszatér az ismeret nevének minimális és maximális hosszával.
     * @return array
     */
    public static function getKnowledgeLength()
    {
        return array(3, 128);
    }
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     * @return \UcKnowledge
     */
    public static function model($param = null)
    {
        $class = get_called_class();
        return new $class;
    }
    /**
     * "Set-up"-olja az objektumot az ügyfél mentéshez.
     * @param \Client $client
     * @return \UcKnowledge
     */
    public function setUpClientSave(\Client $client)
    {
        $this->flag_dirty('ismeret');
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
}