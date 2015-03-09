<?php
namespace Uniweb\Module\Beallitas\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;

class CameTo extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'karrierpont';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'karrierpont_id';
    
    public function attributeLabels()
    {
        return array(
            'karrierpont_id' => 'Azonosító',
            'nev' => 'Név',
            'letrehozo_id' => 'Létrehozó felhasználó',
            'modosito_id' => 'Módosító felhasználó',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma',
            'karrierpont_aktiv' => 'Megjelenik',
            'karrierpont_torolt' => 'Törölt'
        );
    }
    /**
     * @todo Egyediség validáció
     */
    public function validate()
    {
        parent::validate();
    }
}