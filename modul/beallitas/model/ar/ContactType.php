<?php
/**
 * @property int $esetnaplo_tipus_id Esetnapló típus azonosító.
 * @property string $nev Esetnapló típus neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $esetnaplo_tipus_aktiv Aktív-e a rekord.
 * @property int $esetnaplo_tipus_torolt Törölt-e a rekord.
 */
class ContactType extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'esetnaplo_tipus';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'esetnaplo_tipus_id';
    /**
     * Validálja a modelt.
     */
    public function validate()
    {
        if ($this->exists(array('conditions' => array('nev' => $this->nev)))) {
            $this->errors->add('nev', 'Ez a név már foglalt!');
        }
    }
}