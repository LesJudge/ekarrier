<?php
namespace Uniweb\Module\Beallitas\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * @property int $munkarend_id Munkarend azonosító.
 * @property string $nev Munkarend neve.
 * @property int $letrehozo_id Létrehozó azonosítója.
 * @property int $modosito_id Módosító azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property \ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $munkarend_aktiv Aktív-e a mező.
 * @property int $munkarend_torolt Törölt-e a mező.
 */
class WorkSchedule extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'munkarend';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'munkarend_id';
    /**
     * @todo Komplett validáció
     * @todo Egyediség validáció
     */
    public function attributeLabels()
    {
        return array(
            'munkarend_id' => 'Azonosító',
            'nev' => 'Név',
            'has_field' => 'Tartozik hozzá mező',
            'letrehozo_id' => 'Létrehozó felhasználó',
            'modosito_id' => 'Módosító felhasználó',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma',
            'munkarend_aktiv' => 'Megjelenik',
            'munkarend_torolt' => 'Törölt'
        );
    }

    public function validate()
    {
        return parent::validate();
    }
}