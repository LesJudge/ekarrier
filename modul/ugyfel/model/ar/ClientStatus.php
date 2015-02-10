<?php
/**
 * @property int $user_statusz_id Ügyfél státusz azonosító.
 * @property string $nev Státusz neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $user_statusz_aktiv Aktív-e a státusz.
 * @property int $user_statusz_torolt Törölt-e a státusz.
 */
class ClientStatus extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'user_statusz';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'user_statusz_id';
    /**
     * Validálja a modelt.
     * @todo Egyediség ellenőrzése nem megfelelő! Javítani!
     */
    public function validate()
    {
        if ($this->exists(array('conditions' => array('nev' => $this->nev)))) {
            $this->errors->add('nev', 'Ez a név már használatban van!');
        }
    }
}