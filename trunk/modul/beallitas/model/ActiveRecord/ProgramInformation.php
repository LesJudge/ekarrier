<?php
namespace Uniweb\Module\Beallitas\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * Program információ AR Model.
 * 
 * @property int $program_informacio_id Azonosító.
 * @property string $nev Név.
 * @property int $has_field Tartozik-e szöveges mező hozzá.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property \ActiveRecord\DateTime $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $program_informacio_aktiv Aktív-e a rekord.
 * @property int $program_informacio_torolt Törölt-e a rekord.
 */
class ProgramInformation extends ArBase
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
    
    public function attributeLabels()
    {
        return array(
            'program_informacio_id' => 'Azonosító',
            'nev' => 'Név',
            'has_field' => 'Tartozik hozzá mező',
            'letrehozo_id' => 'Létrehozó felhasználó',
            'modosito_id' => 'Módosító felhasználó',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma',
            'program_informacio_aktiv' => 'Megjelenik',
            'program_informacio_torolt' => 'Törölt'
        );
    }
    /**
     * @todo Komplett validáció.
     * @todo Egyediség ellenőrzés.
     */
    public function validate()
    {
        parent::validate();
    }
}