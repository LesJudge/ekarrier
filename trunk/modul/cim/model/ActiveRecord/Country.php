<?php
namespace Uniweb\Module\Cim\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * @property int $cim_orszag_id Ország azonosító.
 * @property string $kod Ország kódja (két karakter hosszú).
 * @property string $nev Ország neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property int $modositas_szama Módosítás száma.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $cim_orszag_aktiv Megjelenhet-e listázáskor.
 * @property int $cim_orszag_torolt Törölt-e az ország.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class Country extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'cim_orszag';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'cim_orszag_id';
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
        )
    );
    
    public function attributeLabels()
    {
        return array(
            'orszag_id' => 'Azonosító',
            'kod' => 'Kód',
            'nev' => 'Név',
            'letrehozo_id' => 'Létrehozó felhasználó',
            'modosito_id' => 'Módosító felhasználó',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma',
            'orszag_aktiv' => 'Megjelenik',
            'orszag_torolt' => 'Törölt'
        );
    }
    /**
     * @todo Komplett validáció
     * @todo Egyediség validáció
     */
    public function validate()
    {
        parent::validate();
    }
}