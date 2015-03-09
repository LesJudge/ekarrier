<?php
namespace Tests\Uniweb\Library\Utilities\ActiveRecord\Src;
use Uniweb\Library\Utilities\ActiveRecord\Model\Behaviorable;
/**
 * @property null|\ActiveRecord\DateTime $created Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modified Módosítás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $creator Létrehozó felhasználó azonosítója.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modificatory Módosító felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property int $nom Módosítások száma.
 * @property int $modositas_szama Módosítás száma.
 * @property int $active Aktív-e a rekord.
 * @property int $aktiv Aktív-e a rekord.
 * @property int $deleted Törölt-e a rekord.
 * @property int $torolt Törölt-e a rekord.
 * 
 * @method CompleteModel in(string $in) Szűrés.
 * @method null|\ActiveRecord\DateTime get_letrehozas_timestamp() Visszatér a létrehozás idejével.
 * @method null|\ActiveRecord\DateTime get_modositas_timestamp() Visszatér a módosítás idejével.
 * @method void set_letrehozas_timestamp(string $letrehozas_timestamp) Beállítja a létrehozás idejét.
 * @method void set_modositas_timestamp(string $modositas_timestamp) Beállítja a módosítás idejét.
 * @method int get_letrehozo_id() Visszatér a létrehozó felhasználó azonosítójával.
 * @method int get_modosito_id() Visszatér a módosító felhasználó azonosítójával.
 * @method void set_letrehozo_id(int $letrehozo_id) Beállítja a létrehozó felhasználó azonosítóját.
 * @method void set_modosito_id(int $modosito_id) Beállítja a módosító felhasználó azonosítóját.
 * @method int get_modositas_szama() Visszatér a módosítások számával.
 * @method void set_modositas_szama(int $modositas_szama) Beállítja a módosítások számát.
 * @method int get_aktiv() Visszatér a rekord aktív értékével.
 * @method int get_torolt() Visszatér a rekord törölt értékével.
 * @method void set_aktiv(int $aktiv) Beállítja a rekord aktív értékét.
 * @method void set_torolt(int $torolt) Beállítja a rekord törölt értékét.
 */
class CompleteModel extends Behaviorable
{
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'id';
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ar_behavior_complete';
    
    public function attributeLabels()
    {
        return array();
    }
}