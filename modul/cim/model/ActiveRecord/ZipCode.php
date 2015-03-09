<?php
namespace Uniweb\Module\Cim\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * @property int $cim_iranyitoszam_id Irányítószám azonosító.
 * @property int $cim_varos_id Város azonosító.
 * @property string $iranyitoszam Irányítószám.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property int $modositas_szama Módosítás száma.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $cim_iranyitoszam_aktiv Megjelenhet-e listázáskor.
 * @property int $cim_iranyitoszam_torolt Törölt-e az irányítószám.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\Cim\Model\ActiveRecord\City $city Város adatok.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class ZipCode extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'cim_iranyitoszam';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'cim_iranyitoszam_id';
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Város kapcsolat.
        array(
            'city',
            'class_name' => '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\City',
            'conditions' => 'cim_varos_aktiv = 1 AND cim_varos_torolt = 0',
            'foreign_key' => 'cim_varos_id',
            'read_only' => true
        ),
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
            'cim_iranyitoszam_id' => 'Azonosító',
            'cim_varos_id' => 'Város',
            'iranyitoszam' => 'Irányítószám',
            'letrehozo_id' => 'Létrehozó felhasználó',
            'modosito_id' => 'Módosító felhasználó',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma',
            'cim_iranyitoszam_aktiv' => 'Megjelenik',
            'cim_iranyitoszam_torolt' => 'Törölt'
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