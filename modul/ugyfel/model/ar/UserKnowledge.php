<?php
/**
 * Felhasználó nyelvtudás ActiveRecord Model.
 * 
 * @property int $ugyfel_id Felhasználó azonosító.
 * @property int $nyelvtudas_nyelv_id Nyelvtudás nyelv azonosítója.
 * @property int $nyelvtudas_szint_id Nyelvtudás szint azonosítója.
 * @property int $letrehozo_id Létrehozó azonosító.
 * @property int $modosito_id Módosító azonosító.
 * @property ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property User $client Felhasználó adatai.
 * @property User $creator Végzettség létrehozójának adatai.
 * @property User $modificatory Végzettség módosítójának adatai.
 * @property Client $client Ügyfél adatai.
 * @property KnowledgeLanguage $language Nyelv adatai.
 * @property KnowledgeLevel $level Nyelvtudás szintje.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class UserKnowledge extends \ArEditable implements \ISheepItAble, \IClientSave
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_nyelvtudas';
    /**
     * Tábla elsődleges kulcsai.
     * @var string
     */
    public static $primary_key = 'ugyfel_id';
    /**
     * Mezők, amelyek nem "mass-assignolhatóak". (Konstruktorban hiába van átadva, NULL értéket vesz fel az attribútum.)
     * @var array
     */
    public static $attr_protected = array(
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
            'nyelvtudas_nyelv_id',
            'message' => 'A nyelv megadása kötelező!'
        ),
        array(
            'nyelvtudas_szint_id',
            'message' => 'A szint megadása kötelező!'
        ),
    );
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
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
            'client',
            'class_name' => 'Client',
            'foreign_key' => 'ugyfel_id',
            'read_only' => true
        ),
        array(
            'language',
            'class_name' => 'KnowledgeLanguage',
            'foreign_key' => 'nyelvtudas_nyelv_id',
            'read_only' => true
        ),
        array(
            'level',
            'class_name' => 'KnowledgeLevel',
            'foreign_key' => 'nyelvtudas_szint_id',
            'read_only' => true
        )
    );
    /**
     * Visszatér a sheepItForm prefixével.
     * @return string
     */
    public static function sheepItPrefix()
    {
        return 'knowledgeForm_#index#';
    }
    /**
     * Visszatér a query-hez elkészített tömbbel.
     * @return array Query-hez elkészített tömb.
     */
    public function sheepItSaveValue()
    {
        $userId = (int)UserLoginOut_Controller::$_id;
        return array(
            $this->ugyfel_id,
            $this->nyelvtudas_nyelv_id,
            $this->nyelvtudas_szint_id,
            $userId,
            $userId,
            date('Y-m-d H:i:s'),
            0,
            0,
            $this->nyelvtudas_nyelv_id,
            $this->nyelvtudas_szint_id,
            $userId
        );
    }
    /**
     * Visszatér a végrehajtandó SQL Query-vel.
     * @return string
     */
    public function sheepItSaveQuery()
    {
        return 'INSERT INTO ' . static::$table_name . ' (
                    ugyfel_id,
                    nyelvtudas_nyelv_id,
                    nyelvtudas_szint_id,
                    letrehozo_id,
                    modosito_id,
                    letrehozas_timestamp,
                    modositas_timestamp,
                    modositas_szama,
                    ' . static::$table_name .'_aktiv,
                    ' . static::$table_name . '_torolt
                ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, 0) 
                ON DUPLICATE KEY UPDATE 
                nyelvtudas_nyelv_id = ?,
                nyelvtudas_szint_id = ?,
                modositas_timestamp = NOW(),
                modosito_id = ?,
                modositas_szama = modositas_szama + 1, 
                ' . static::$table_name . '_aktiv = 1,
                ' . static::$table_name . '_torolt = 0';
    }
    /**
     * Törli az összes sheepIt rekordot.
     */
    public function sheepItDelete()
    {
        $query = 'UPDATE ' . static::$table_name . ' SET ' . static::$table_name .'_torolt = 1 WHERE ugyfel_id = ?';
        self::query($query, array($this->ugyfel_id));
    }
    /**
     * Elkészíti az objektum serializálható (sheepIt) megfelelőjét.
     * @return array
     */
    public function sheepIt2Serializable()
    {
        $prefix = $this->sheepItPrefix();
        $json = array(
            $prefix . '_nyelvtudas_nyelv_id' => $this->read_attribute('nyelvtudas_nyelv_id'),
            $prefix . '_nyelvtudas_szint_id' => $this->read_attribute('nyelvtudas_szint_id')
        );
        $errors = $this->errors;
        $closure = function(&$json, $attribute) use ($errors, $prefix) {
            $error = null;
            if (is_object($errors) && ($error = $errors->on($attribute))) {
                $error = ArErrorRenderer::processErrorMessage($error);
            }
            $json[$prefix . '_' . $attribute . '_error'] = $error;
        };
        $closure($json, 'nyelvtudas_nyelv_id');
        $closure($json, 'nyelvtudas_szint_id');
        return $json;
    }
    /**
     * Példányosít egy objektumot az ügyfél mentéshez.
     * @param mixed $param
     * @return \UserKnowledge
     */
    public static function model($param = null)
    {
        $class = get_called_class();
        return new $class;
    }
    /**
     * "Set-up"-olja az objektumot az ügyfél mentéshez.
     * @param \Client $client
     * @return \UserKnowledge
     */
    public function setUpClientSave(\Client $client)
    {
        $this->flag_dirty('nyelvtudas_nyelv_id');
        $this->flag_dirty('nyelvtudas_szint_id');
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