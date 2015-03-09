<?php
namespace Uniweb\Module\Cim\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * @property int $cim_megye_id Megye azonosító.
 * @property string $cim_megye_nev Megye neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property int $modositas_szama Módosítás száma.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $cim_megye_aktiv Megjelenhet-e listázáskor.
 * @property int $cim_megye_torolt Törölt-e a megye.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class County extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'cim_megye';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'cim_megye_id';
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
            'cim_megye_id' => 'Azonosító',
            'cim_megye_nev' => 'Név',
            'letrehozo_id' => 'Létrehozó felhasználó',
            'modosito_id' => 'Módosító felhasználó',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma',
            'cim_megye_aktiv' => 'Megjelenik',
            'cim_megye_torolt' => 'Törölt'
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