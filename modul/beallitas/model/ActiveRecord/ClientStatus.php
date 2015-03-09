<?php
namespace Uniweb\Module\Beallitas\Model\ActiveRecord;
use ActiveRecord\Model as ArBase;
use Uniweb\Library\Utilities\ActiveRecord\Validator\IsUnique;
/**
 * @property int $ugyfel_statusz_id Ügyfél státusz azonosító.
 * @property string $nev Státusz neve.
 * @property int $letrehozo_id Létrehozó felhasználó azonosítója.
 * @property int $modosito_id Módosító felhasználó azonosítója.
 * @property \ActiveRecord\DateTime $letrehozas_timestamp Létrehozás ideje.
 * @property mixed $modositas_timestamp Módosítás ideje.
 * @property int $modositas_szama Módosítás száma.
 * @property int $ugyfel_statusz_aktiv Aktív-e a státusz.
 * @property int $ugyfel_statusz_torolt Törölt-e a státusz.
 * 
 * Kapcsolatok:
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $creator Létrehozó felhasználó adatai.
 * @property \Uniweb\Module\User\Model\ActiveRecord\User $modificatory Módosító felhasználó adatai.
 */
class ClientStatus extends ArBase
{
    /**
     * Tábla neve.
     * @var string
     */
    public static $table_name = 'ugyfel_statusz';
    /**
     * Tábla elsődleges kulcsa.
     * @var string
     */
    public static $primary_key = 'ugyfel_statusz_id';
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
    /**
     * Validálja a modelt.
     */
    public function validate()
    {
        $isUnique = new IsUnique($this, 'nev');
        if (!$isUnique->validate($this->nev)) {
            $this->errors->add('nev', 'Ez a név már használatban van!');
        }
    }
}