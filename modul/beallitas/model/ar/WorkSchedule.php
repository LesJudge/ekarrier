<?php
/**
 * @property int $munkarend_id Munkarend azonosító.
 * @property string $munkarend_nev Munkarend neve.
 * @property int $letrehozo_id Létrehozó azonosítója.
 * @property int $modosito_id Módosító azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property \ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $munkarend_aktiv Aktív-e a mező.
 * @property int $munkarend_torolt Törölt-e a mező.
 * @property \User $creator Létrehozó felhasználó adatai.
 * @property \User $modificatory Módosító felhasználó adatai.
 */
class WorkSchedule extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    static $table_name = 'munkarend';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    static $primary_key = 'munkarend_id';
}