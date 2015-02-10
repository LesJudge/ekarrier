<?php
/**
 * Végzettség AR Model.
 * 
 * @property int $vegzettseg_id Végzettség azonosító.
 * @property int $nyelv_id Nyelv azonosító.
 * @property string $vegzettseg_nev Végzettség neve.
 * @property int $vegzettseg_javitas_szama Végzettség módosításainak száma.
 * @property \ActiveRecord\DateTime $vegzettseg_create_date Végzettség létrehozásának ideje.
 * @property \ActiveRecord\DateTime $vegzettseg_modositas_datum Végzettség módosításának ideje.
 * @property int $vegzettseg_letrehozo Végzettség létrehozójának felhasználó azonosítója.
 * @property int $vegzettseg_modosito Végzettség módosítójának felhasználó azonosítója.
 * @property int $vegzettseg_aktiv Aktív-e a végzettség.
 * @property int $vegzettseg_torolt Törölt-e a végzettség.
 * @property User $creator Végzettséget létrehozó adatai.
 * @property User $modificatory Végzettséget módosító felhasználó adatai.
 */
class Education extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    static $table_name = 'vegzettseg';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    static $primary_key = 'vegzettseg_id';
    /**
     * Létrehozás idejét tároló mező neve.
     * @var mixed
     */
    protected $createdAttribte = 'vegzettseg_create_date';
    /**
     * Módosítás idejét tároló mező neve.
     * @var mixed
     */
    protected $modifiedAttribute = 'vegzettseg_modositas_datum';
    /**
     * Létrehozó felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $creatorAttribute = 'vegzettseg_letrehozo';
    /**
     * Módosító felhasználó azonosítóját tároló mező neve.
     * @var mixed
     */
    protected $modificatoryAttribute = 'vegzettseg_modosito';
    /**
     * Módosítások számát tároló mező neve.
     * @var mixed
     */
    protected $nomAttribute = 'vegzettseg_modositas_szama';
}