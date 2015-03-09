<?php
namespace Uniweb\Module\Cim\Model\ActiveRecord;
use Uniweb\Library\Utilities\ActiveRecord\Model\ArBase;
/**
 * @property int $cim_varos_id Város azonosító.
 * @property int $cim_orszag_id Ország azonosító.
 * @property int $cim_megye_id Megye azonosító.
 * @property string $cim_varos_nev Város neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property int $modositas_szama Módosítás száma.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítása ideje.
 * @property int $cim_varos_aktiv Megjelenhet-e listázáskor.
 * @property int $cim_varos_torolt Törölt-e a város.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\Cim\Model\ActiveRecord\Country $country Ország kapcsolat.
 * @property \Uniweb\Module\Cim\Model\ActiveRecord\County $county Megye kapcsolat.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class City extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'cim_varos';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'cim_varos_id';
    /**
     * 1:1 kapcsolatok.
     * @var array
     */
    public static $belongs_to = array(
        // Ország kapcsolat.
        array(
            'country',
            'class_name' => '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\Country',
            'conditions' => 'cim_orszag_aktiv = 1 AND cim_orszag_torolt = 0',
            'foreign_key' => 'cim_orszag_id',
            'read_only' => true
        ),
        // Megye kapcsolat.
        array(
            'county',
            'class_name' => '\\Uniweb\\Module\\Cim\\Model\\ActiveRecord\\County',
            'conditions' => 'cim_megye_aktiv = 1 AND cim_megye_torolt = 0',
            'foreign_key' => 'cim_megye_id',
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
            'cim_varos_id' => 'Azonosító',
            'cim_orszag_id' => 'Ország',
            'cim_megye_id' => 'Megye',
            'cim_varos_nev' => 'Név',
            'letrehozo_id' => 'Létrehozó felhasználó',
            'modosito_id' => 'Módosító felhasználó',
            'letrehozas_timestamp' => 'Létrehozás ideje',
            'modositas_timestamp' => 'Módosítás ideje',
            'modositas_szama' => 'Módosítás száma',
            'cim_varos_aktiv' => 'Megjelenik',
            'cim_varos_torolt' => 'Törölt'
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