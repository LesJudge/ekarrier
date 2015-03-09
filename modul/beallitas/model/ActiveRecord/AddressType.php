<?php
namespace Uniweb\Module\Beallitas\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * @property int $ugyfel_cim_tipus_id Azonosító.
 * @property string $nev Név.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_cim_tipus_aktiv Megjelenik-e a listában.
 * @property int $ugyfel_cim_tipus_torolt Törölt-e a cím típus.
 */
class AddressType extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_cim_tipus';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_cim_tipus_id';
    
    public function attributeLabels()
    {
        return array(
            'ugyfel_cim_tipus_id' => 'Azonosító',
            'nev' => 'Név',
            'letrehozo_id' => 'Létrehozó felhasználó',
            'modosito_id' => 'Módosító felhasználó',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma',
            'ugyfel_cim_tipus_aktiv' => 'Megjelenik',
            'ugyfel_cim_tipus_torolt' => 'Törölt'
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