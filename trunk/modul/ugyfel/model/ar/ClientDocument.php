<?php
/**
 * @property int $ugyfel_attr_dokumentum_id Dokumentum azonosító.
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property string $nev Dokumentum kódolt neve.
 * @property string $dokumentum_nev Dokumentum eredeti neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 */
class ClientDocument extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_dokumentum';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_dokumentum_id';
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
        )
    );
    /**
     * Modelhez tartozó behavior-ök.
     * @return array
     */
    public function arBehaviors()
    {
        return array(
            'ArTimestampBehavior' => array(
                'createdAttribute' => 'letrehozas_timestamp',
                'modifiedAttribute' => null
            ),
            'ArAuthorBehavior' => array(
                'creatorAttribute' => 'letrehozo_id',
                'modificatoryAttribute' => null
            )
        );
    }
    /**
     * Mentés előtt lefutó metódus.
     */
    public function before_save()
    {
        $ext = pathinfo($this->dokumentum_nev, PATHINFO_EXTENSION);
        $this->dokumentum_nev = substr(str_replace($ext, '', $this->dokumentum_nev), 0, 230) . $ext;
        $this->nev = md5(str_shuffle(uniqid(time()) . $this->dokumentum_nev)) . '.' . $ext;
    }
}