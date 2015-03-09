<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\BaseResourcable;
/**
 * @property int $ugyfel_attr_projekt_id Rekord azonosító.
 * @property int $projekt_id Projekt azonosító.
 * @property int $ugyfel_id Ügyfél azonosító.
 * @property string $megjegyzes Megjegyzés.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property null|\ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_attr_projekt_aktiv Megjelenhet-e listázáskor a rekord.
 * @property int $ugyfel_attr_projekt_torolt Törölt-e a rekord.
 * 
 * @property \Uniweb\Module\Ugyfel\Model\ActiveRecord\Client $client Ügyfél objektum.
 * @property \Uniweb\Module\Projekt\Model\ActiveRecord\Project $project Projekt objektum.
 */
class Project extends BaseResourcable
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_attr_projekt';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_attr_projekt_id';
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Létrehozó kapcsolat.
        array(
            'creator',
            'class_name' => '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User',
            'conditions' => 'user_aktiv = 1 AND user_torolt = 0',
            'foreign_key' => 'letrehozo_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login'
        ),
        // Módosító kapcsolat.
        array(
            'modificatory',
            'class_name' => '\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User',
            'conditions' => 'user_aktiv = 1 AND user_torolt = 0',
            'foreign_key' => 'modosito_id',
            'read_only' => true,
            'select' => 'user_id, user_fnev, user_email, user_vnev, user_knev, user_last_login'
        ),
        // Projekt kapcsolat.
        array(
            'project',
            'class_name' => '\\Uniweb\\Module\\Projekt\\Model\\ActiveRecord\\Project',
            'foreign_key' => 'projekt_id',
            'read_only' => true
        )
    );
}