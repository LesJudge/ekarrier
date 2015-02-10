<?php
abstract class ArEditable extends \ArBase
{
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
     * Modelhez tartozó behavior-ök.
     * @return array
     */
    public function arBehaviors()
    {
        return array(
            'ArTimestampBehavior' => array(
                'createdAttribute' => $this->createdAttribte,
                'modifiedAttribute' => $this->modifiedAttribute
            ),
            'ArAuthorBehavior' => array(
                'creatorAttribute' => $this->creatorAttribute,
                'modificatoryAttribute' => $this->modificatoryAttribute
            ),
            'ArNomBehavior' => array(
                'nomAttribute' => $this->nomAttribute
            )
        );
    }
    /**
     * Visszatér az összes aktív, nem törölt rekorddal.
     * @return array
     */
    public static function findAllActiveNotDeleted()
    {
        return self::find('all', static::scopeActiveNotDeleted());
    }
    /**
     * Aktív, nem törölt szűrő.
     * @return array
     */
    public static function scopeActiveNotDeleted()
    {
        return array(
            'conditions' => array(
                static::$table_name . '_aktiv' => 1,
                static::$table_name . '_torolt' => 0
            )
        );
    }
    /**
     * Id és név párosok.
     * @return array
     */
    public static function patternIdNamePairs()
    {
        return array(
            'only' => array(
                static::$table_name . '_id',
                static::$table_name . '_nev'
            )
        );
    }
    /**
     * Visszatér a létrehozás idejét tároló mező nevével.
     * @return mixed
     */
    public function getCreatedAttribte()
    {
        return $this->createdAttribte;
    }
    /**
     * Visszatér a módosítás idejét tároló mező nevével.
     * @return mixed
     */
    public function getModifiedAttribute()
    {
        return $this->modifiedAttribute;
    }
    /**
     * Visszatér a létrehozó felhasználó azonosítóját tároló mező nevével.
     * @return mixed
     */
    public function getCreatorAttribute()
    {
        return $this->creatorAttribute;
    }
    /**
     * Visszatér a módosító felhasználó azonosítóját tároló mező nevével.
     * @return mixed
     */
    public function getModificatoryAttribute()
    {
        return $this->modificatoryAttribute;
    }
    /**
     * Visszatér a módosítás számát tároló mező nevével.
     * @return mixed
     */
    public function getNomAttribute()
    {
        return $this->nomAttribute;
    }
}