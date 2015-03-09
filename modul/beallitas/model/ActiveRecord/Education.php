<?php
namespace Uniweb\Module\Beallitas\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * Végzettség AR Model.
 * 
 * @property int $vegzettseg_id Végzettség azonosító.
 * @property int $nyelv_id Nyelv azonosító.
 * @property string $nev Végzettség neve.
 * @property int $modositas_szama Végzettség módosításainak száma.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Végzettség létrehozásának ideje.
 * @property \ActiveRecord\DateTime $modositas_timestamp Végzettség módosításának ideje.
 * @property int $letrehozo_id Végzettség létrehozójának felhasználó azonosítója.
 * @property int $modosito_id Végzettség módosítójának felhasználó azonosítója.
 * @property int $vegzettseg_aktiv Aktív-e a végzettség.
 * @property int $vegzettseg_torolt Törölt-e a végzettség.
 * @property User $creator Végzettséget létrehozó adatai.
 * @property User $modificatory Végzettséget módosító felhasználó adatai.
 */
class Education extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'vegzettseg';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'vegzettseg_id';
    
    public function attributeLabels()
    {
        return array(
            'vegzettseg_id' => 'Azonosító',
            'nyelv_id' => 'Nyelv',
            'nev' => 'Név',
            'letrehozo_id' => 'Létrehozó felhasználó',
            'modosito_id' => 'Módosító felhasználó',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma',
            'vegzettseg_aktiv' => 'Megjelenik',
            'vegzettseg_torolt' => 'Törölt'
        );
    }
}