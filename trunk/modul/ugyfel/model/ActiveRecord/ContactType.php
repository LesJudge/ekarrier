<?php
namespace Uniweb\Module\Ugyfel\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * @property int $ugyfel_esetnaplo_tipus_id Esetnapló típus azonosító.
 * @property string $nev Esetnapló típus neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_esetnaplo_tipus_aktiv Aktív-e a rekord.
 * @property int $ugyfel_esetnaplo_tipus_torolt Törölt-e a rekord.
 */
class ContactType extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_esetnaplo_tipus';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_esetnaplo_tipus_id';
}