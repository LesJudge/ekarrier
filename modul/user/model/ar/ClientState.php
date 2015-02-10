<?php
/**
 * @property int $user_allapot_id Ügyfél állapot azonosító.
 * @property string $nev Ügyfél állapot neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $user_allapot_aktiv Aktív-e az állapot.
 * @property int $user_allapot_torolt Törölt-e az állapot.
 */
class ClientState extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'user_allapot';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'user_allapot_id';
    /**
     * Validálja a modelt.
     * @todo Egyediség ellenőrzése nem megfelelő, javítani!
     */
    public function validate()
    {
        if ($this->exists(array('conditions' => array('nev' => $this->nev)))) {
            $this->errors->add('nev', 'Ez a név már használatban van!');
        }
    }
}