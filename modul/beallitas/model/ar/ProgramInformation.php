<?php
/**
 * Program információ AR Model.
 * 
 * @property int $program_informacio_id Azonosító.
 * @property string $program_informacio_nev Név.
 * @property int $has_field Tartozik-e szöveges mező hozzá.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property \ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $program_informacio_aktiv Aktív-e a rekord.
 * @property int $program_informacio_torolt Törölt-e a rekord.
 * @property User $creator Végzettséget létrehozó adatai.
 * @property User $modificatory Végzettséget módosító felhasználó adatai.
 */
class ProgramInformation extends \ArEditable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'program_informacio';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'program_informacio_id';
    /**
     * Visszatér az összes aktív, nem törölt rekorddal.
     * @return array
     */
    public static function findAllActiveNotDeleted()
    {
        return self::find('all', array(
            'conditions' => array(
                'program_informacio_aktiv' => 1,
                'program_informacio_torolt' => 0
            ),
            'select' => 'program_informacio_id, program_informacio_nev, has_field'
        ));
    }
}